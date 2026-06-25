const { OAuth2Client } = require("google-auth-library");
const googleClient = new OAuth2Client(process.env.GOOGLE_CLIENT_ID);

const db = require("../config/db");
const bcrypt = require("bcrypt");
const jwt = require("jsonwebtoken");
const nodemailer = require("nodemailer");

// Sahi Aur Dynamic Transporter Logic
// Direct and Robust Mailtrap Transporter
const transporter = nodemailer.createTransport({
    host: "sandbox.smtp.mailtrap.io",
    port: 2525,
    auth: {
        user: "8fb2ff78cd1124", 
        pass: "7b823e20e8b1b5"  
    },
    tls: {
        rejectUnauthorized: false
    }
});

function generateSixDigitCode() {
    return Math.floor(100000 + Math.random() * 900000).toString();
}

async function ensureAdminAuthTable() {
    await db.query(`
        CREATE TABLE IF NOT EXISTS admin_auth (
            id INT AUTO_INCREMENT PRIMARY KEY,
            email VARCHAR(255) NOT NULL UNIQUE,
            password_hash VARCHAR(255) NOT NULL,
            reset_code VARCHAR(10) NULL,
            reset_expires DATETIME NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )
    `);

    const adminEmail = String(process.env.ADMIN_EMAIL || "").trim().toLowerCase();
    const defaultPassword = String(process.env.ADMIN_DEFAULT_PASSWORD || "").trim();

    if (!adminEmail || !defaultPassword) {
        throw new Error("ADMIN_EMAIL or ADMIN_DEFAULT_PASSWORD missing in .env");
    }

    const [admins] = await db.query(
        "SELECT * FROM admin_auth WHERE LOWER(TRIM(email)) = ?",
        [adminEmail]
    );

    if (admins.length === 0) {
        const hashedPassword = await bcrypt.hash(defaultPassword, 10);

        await db.query(
            "INSERT INTO admin_auth (email, password_hash) VALUES (?, ?)",
            [adminEmail, hashedPassword]
        );

        console.log("✅ Default admin created:", adminEmail);
    } else {
        console.log("✅ Admin auth table checked. Existing admin preserved:", adminEmail);
    }
}

// Users table ko automatic create karne ka logic
async function ensureUsersTable() {
    await db.query(`
        CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            otp_code VARCHAR(10) NULL,
            is_verified TINYINT DEFAULT 0,
            reset_code VARCHAR(10) NULL,
            reset_expires DATETIME NULL,
            experience_level VARCHAR(50) NULL,
            is_student TINYINT NULL,
            education_level VARCHAR(100) NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    `);
    console.log("✅ Users table checked/created successfully.");
}

async function ensureUserPasswordResetColumns() {
    const databaseName = process.env.DB_NAME || process.env.MYSQL_DATABASE || "dynamic_resume_db";

    const [resetCodeColumns] = await db.query(
        `SELECT COLUMN_NAME 
         FROM INFORMATION_SCHEMA.COLUMNS 
         WHERE TABLE_SCHEMA = ? AND TABLE_NAME = 'users' AND COLUMN_NAME = 'reset_code'`,
        [databaseName]
    );

    if (resetCodeColumns.length === 0) {
        await db.query("ALTER TABLE users ADD COLUMN reset_code VARCHAR(10) NULL");
    }

    const [resetExpiresColumns] = await db.query(
        `SELECT COLUMN_NAME 
         FROM INFORMATION_SCHEMA.COLUMNS 
         WHERE TABLE_SCHEMA = ? AND TABLE_NAME = 'users' AND COLUMN_NAME = 'reset_expires'`,
        [databaseName]
    );

    if (resetExpiresColumns.length === 0) {
        await db.query("ALTER TABLE users ADD COLUMN reset_expires DATETIME NULL");
    }
}

// User Registration Logic with OTP
exports.register = async (req, res) => {
    const { name, email, password } = req.body;

    try {
        await ensureUsersTable(); // Register karne se pehle table check karega
        const [existingUser] = await db.query(
            "SELECT * FROM users WHERE email = ?",
            [email]
        );

        if (existingUser.length > 0) {
            return res.status(400).json({
                success: false,
                message: "Email already registered!"
            });
        }

        const hashedPassword = await bcrypt.hash(password, 10);
        const otp = generateSixDigitCode();

        await db.query(
            "INSERT INTO users (name, email, password, otp_code) VALUES (?, ?, ?, ?)",
            [name, email, hashedPassword, otp]
        );

// Register ke andar isko aise badlein:
await transporter.sendMail({
    from: `"Resume Builder Live Test" <8fb2ff78cd1124>`, // Yahan "Live Test" likh dein
    to: email,
    subject: "Your Verification Code",
    text: `Aapka verification code yeh hai: ${otp}`
});

        res.status(201).json({
            success: true,
            message: "OTP sent to your email!"
        });
    } catch (error) {
        console.error("Register error:", error);
        res.status(500).json({
            success: false,
            message: "Registration failed."
        });
    }
};

// OTP Verification API
exports.verifyOTP = async (req, res) => {
    const { email, otp } = req.body;

    try {
        const [users] = await db.query(
            "SELECT * FROM users WHERE email = ? AND otp_code = ?",
            [email, otp]
        );

        if (users.length === 0) {
            return res.status(400).json({
                success: false,
                message: "Invalid OTP!"
            });
        }

        await db.query(
            "UPDATE users SET is_verified = 1, otp_code = NULL WHERE email = ?",
            [email]
        );

        res.status(200).json({
            success: true,
            message: "Email verified successfully!"
        });
    } catch (error) {
        console.error("OTP verify error:", error);
        res.status(500).json({
            success: false,
            message: "Verification error."
        });
    }
};

// User Login Logic
exports.login = async (req, res) => {
    const { email, password } = req.body;

    try {
        const [users] = await db.query(
            "SELECT * FROM users WHERE email = ?",
            [email]
        );

        if (users.length === 0) {
            return res.status(400).json({
                success: false,
                message: "Invalid email or password."
            });
        }

        const user = users[0];

        if (user.is_verified === 0) {
            return res.status(403).json({
                success: false,
                message: "Please verify your email first."
            });
        }

        const isMatch = await bcrypt.compare(password, user.password);

        if (!isMatch) {
            return res.status(400).json({
                success: false,
                message: "Invalid email or password."
            });
        }

        const token = jwt.sign(
            { id: user.id, email: user.email },
            process.env.JWT_SECRET,
            { expiresIn: "2h" }
        );

        res.status(200).json({
            success: true,
            message: "Logged in successfully!",
            token
        });
    } catch (error) {
        console.error("Login error:", error);
        res.status(500).json({
            success: false,
            message: "Server error during login."
        });
    }
};

// Google Login/Signup Logic
exports.googleLogin = async (req, res) => {
    const { token } = req.body;

    try {
        const ticket = await googleClient.verifyIdToken({
            idToken: token,
            audience: process.env.GOOGLE_CLIENT_ID
        });

        const payload = ticket.getPayload();
        const email = payload.email;
        const name = payload.name;

        const [users] = await db.query(
            "SELECT * FROM users WHERE email = ?",
            [email]
        );

        let user;

        if (users.length === 0) {
            const [result] = await db.query(
                "INSERT INTO users (name, email, password, is_verified) VALUES (?, ?, ?, ?)",
                [name, email, "google_sso_user", 1]
            );

            user = {
                id: result.insertId,
                email,
                name
            };
        } else {
            user = users[0];
        }

        const jwtToken = jwt.sign(
            { id: user.id, email: user.email },
            process.env.JWT_SECRET,
            { expiresIn: "2h" }
        );

        res.status(200).json({
            success: true,
            message: "Google Login Successful!",
            token: jwtToken
        });
    } catch (error) {
        console.error("Google Auth Error:", error);
        res.status(500).json({
            success: false,
            message: "Google authentication failed."
        });
    }
};

// Get User Profile
exports.getUserProfile = async (req, res) => {
    try {
        const [users] = await db.query(
            "SELECT id, name, email FROM users WHERE id = ?",
            [req.user.id]
        );

        if (users.length === 0) {
            return res.status(404).json({
                success: false,
                message: "User not found."
            });
        }

        res.status(200).json({
            success: true,
            user: users[0]
        });
    } catch (error) {
        console.error("Profile Fetch Error:", error);
        res.status(500).json({
            success: false,
            message: "Server error while fetching profile."
        });
    }
};

// Update User Onboarding Data
exports.updateOnboarding = async (req, res) => {
    const { experience_level, is_student, education_level } = req.body;
    const userId = req.user.id;

    try {
        let query = "UPDATE users SET ";
        const values = [];

        if (experience_level !== undefined) {
            query += "experience_level = ? ";
            values.push(experience_level);
        }

        if (is_student !== undefined) {
            query += (values.length > 0 ? ", " : "") + "is_student = ? ";
            values.push(is_student);
        }

        if (education_level !== undefined) {
            query += (values.length > 0 ? ", " : "") + "education_level = ? ";
            values.push(education_level);
        }

        if (values.length === 0) {
            return res.status(400).json({
                success: false,
                message: "No onboarding data provided."
            });
        }

        query += "WHERE id = ?";
        values.push(userId);

        await db.query(query, values);

        res.status(200).json({
            success: true,
            message: "Profile updated successfully!"
        });
    } catch (error) {
        console.error("Onboarding Update Error:", error);
        res.status(500).json({
            success: false,
            message: "Server error while updating profile."
        });
    }
};

// Admin Login
exports.adminLogin = async (req, res) => {
    const { email, password } = req.body;

    try {
        await ensureAdminAuthTable();

        const requestedEmail = String(email || "").trim().toLowerCase();
        const requestedPassword = String(password || "").trim();

        console.log("Login Email:", requestedEmail);
        console.log("Login Password:", requestedPassword);

        if (!requestedEmail || !requestedPassword) {
            return res.status(400).json({
                success: false,
                message: "Email and password are required."
            });
        }

        const [admins] = await db.query(
            "SELECT * FROM admin_auth WHERE LOWER(TRIM(email)) = ?",
            [requestedEmail]
        );

        if (admins.length === 0) {
            return res.status(400).json({
                success: false,
                message: "Invalid admin email or password."
            });
        }

        const admin = admins[0];

        const isMatch = await bcrypt.compare(
            requestedPassword,
            admin.password_hash
        );

        console.log("Password Match:", isMatch);

        if (!isMatch) {
            return res.status(400).json({
                success: false,
                message: "Invalid admin email or password."
            });
        }

        const token = jwt.sign(
            { id: admin.id, email: admin.email, role: "admin" },
            process.env.JWT_SECRET,
            { expiresIn: "2h" }
        );

        return res.status(200).json({
            success: true,
            message: "Admin logged in successfully!",
            token
        });
    } catch (error) {
        console.error("Admin login error:", error);

        return res.status(500).json({
            success: false,
            message: "Server error during admin login."
        });
    }
};

// Admin Forgot Password: Send Code
exports.forgotAdminPassword = async (req, res) => {
    const { email } = req.body;

    try {
        await ensureAdminAuthTable();

        if (!email) {
            return res.status(400).json({
                success: false,
                message: "Email is required."
            });
        }

        const requestedEmail = String(email).trim().toLowerCase();
        const adminEmail = String(process.env.ADMIN_EMAIL || "").trim().toLowerCase();

        console.log("Requested Email:", requestedEmail);
        console.log("ENV Admin Email:", adminEmail);

        if (requestedEmail !== adminEmail) {
            return res.status(404).json({
                success: false,
                message: "Admin email not found."
            });
        }

        const code = generateSixDigitCode();
        const expiresAt = new Date(Date.now() + 10 * 60 * 1000);

        await db.query(
            "UPDATE admin_auth SET reset_code = ?, reset_expires = ? WHERE email = ?",
            [code, expiresAt, requestedEmail]
        );

        await transporter.sendMail({
            from: `"Resume Builder Admin" <${process.env.MAIL_USER}>`,
            to: requestedEmail,
            subject: "Admin Password Reset Code",
            text: `Aapka admin password reset code yeh hai: ${code}. Yeh code 10 minutes tak valid hai.`
        });

        res.status(200).json({
            success: true,
            message: "Reset code sent to admin email."
        });
    } catch (error) {
        console.error("Forgot admin password error:", error);
        res.status(500).json({
            success: false,
            message: "Failed to send reset code."
        });
    }
};

// Admin Verify Reset Code
exports.verifyAdminResetCode = async (req, res) => {
    const { email, otp } = req.body;

    try {
        await ensureAdminAuthTable();

        if (!email || !otp) {
            return res.status(400).json({
                success: false,
                message: "Email and code are required."
            });
        }

        const [admins] = await db.query(
            "SELECT * FROM admin_auth WHERE email = ? AND reset_code = ? AND reset_expires > NOW()",
            [email, otp]
        );

        if (admins.length === 0) {
            return res.status(400).json({
                success: false,
                message: "Invalid or expired reset code."
            });
        }

        res.status(200).json({
            success: true,
            message: "Code verified successfully."
        });
    } catch (error) {
        console.error("Verify admin reset code error:", error);
        res.status(500).json({
            success: false,
            message: "Failed to verify reset code."
        });
    }
};

// Admin Reset Password
exports.resetAdminPassword = async (req, res) => {
    const { email, otp, newPassword, confirmPassword } = req.body;

    try {
        await ensureAdminAuthTable();

        if (!email || !otp || !newPassword || !confirmPassword) {
            return res.status(400).json({
                success: false,
                message: "All fields are required."
            });
        }

        if (newPassword !== confirmPassword) {
            return res.status(400).json({
                success: false,
                message: "New password and confirm password do not match."
            });
        }

        if (newPassword.length < 6) {
            return res.status(400).json({
                success: false,
                message: "Password must be at least 6 characters."
            });
        }

        const [admins] = await db.query(
            "SELECT * FROM admin_auth WHERE email = ? AND reset_code = ? AND reset_expires > NOW()",
            [email, otp]
        );

        if (admins.length === 0) {
            return res.status(400).json({
                success: false,
                message: "Invalid or expired reset code."
            });
        }

        const hashedPassword = await bcrypt.hash(newPassword, 10);

        await db.query(
            "UPDATE admin_auth SET password_hash = ?, reset_code = NULL, reset_expires = NULL WHERE email = ?",
            [hashedPassword, email]
        );

        res.status(200).json({
            success: true,
            message: "Admin password updated successfully."
        });
    } catch (error) {
        console.error("Reset admin password error:", error);
        res.status(500).json({
            success: false,
            message: "Failed to reset admin password."
        });
    }
};


// User Forgot Password: Send Reset Code
exports.forgotUserPassword = async (req, res) => {
    const { email } = req.body;

    try {
        await ensureUsersTable(); // Forgot password chalne se pehle table check karega
        await ensureUserPasswordResetColumns();

        if (!email) {
            return res.status(400).json({
                success: false,
                message: "Email address is required."
            });
        }

        const requestedEmail = String(email).trim().toLowerCase();

        const [users] = await db.query(
            "SELECT id, name, email, is_verified FROM users WHERE LOWER(TRIM(email)) = ?",
            [requestedEmail]
        );

        if (users.length === 0) {
            return res.status(404).json({
                success: false,
                message: "This email is not registered. Please sign up first."
            });
        }

        const user = users[0];

        if (user.is_verified === 0) {
            return res.status(403).json({
                success: false,
                message: "Please verify your email before resetting your password."
            });
        }

        const code = generateSixDigitCode();
        const expiresAt = new Date(Date.now() + 10 * 60 * 1000);

        await db.query(
            "UPDATE users SET reset_code = ?, reset_expires = ? WHERE id = ?",
            [code, expiresAt, user.id]
        );

// Register ke andar isko aise badlein:
await transporter.sendMail({
    from: `"Resume Builder Live Test" <8fb2ff78cd1124>`, // Yahan "Live Test" likh dein
    to: email,
    subject: "Your Verification Code",
    text: `Aapka verification code yeh hai: ${otp}`
});

        return res.status(200).json({
            success: true,
            message: "Password reset code sent to your registered email."
        });
    } catch (error) {
        console.error("Forgot user password error:", error);
        return res.status(500).json({
            success: false,
            message: "Failed to send reset code. Please try again."
        });
    }
};

// User Verify Reset Code
exports.verifyUserResetCode = async (req, res) => {
    const { email, otp } = req.body;

    try {
        await ensureUserPasswordResetColumns();

        if (!email || !otp) {
            return res.status(400).json({
                success: false,
                message: "Email and reset code are required."
            });
        }

        const requestedEmail = String(email).trim().toLowerCase();
        const requestedOtp = String(otp).trim();

        const [users] = await db.query(
            `SELECT id, email 
             FROM users 
             WHERE LOWER(TRIM(email)) = ? 
             AND reset_code = ? 
             AND reset_expires > NOW()`,
            [requestedEmail, requestedOtp]
        );

        if (users.length === 0) {
            return res.status(400).json({
                success: false,
                message: "Invalid or expired reset code. Please request a new code."
            });
        }

        return res.status(200).json({
            success: true,
            message: "Reset code verified successfully."
        });
    } catch (error) {
        console.error("Verify user reset code error:", error);
        return res.status(500).json({
            success: false,
            message: "Failed to verify reset code."
        });
    }
};

// User Reset Password
exports.resetUserPassword = async (req, res) => {
    const { email, otp, newPassword, confirmPassword } = req.body;

    try {
        await ensureUserPasswordResetColumns();

        if (!email || !otp || !newPassword || !confirmPassword) {
            return res.status(400).json({
                success: false,
                message: "All fields are required."
            });
        }

        if (newPassword !== confirmPassword) {
            return res.status(400).json({
                success: false,
                message: "New password and confirm password do not match."
            });
        }

        if (newPassword.length < 6) {
            return res.status(400).json({
                success: false,
                message: "Password must be at least 6 characters."
            });
        }

        const requestedEmail = String(email).trim().toLowerCase();
        const requestedOtp = String(otp).trim();

        const [users] = await db.query(
            `SELECT id, email 
             FROM users 
             WHERE LOWER(TRIM(email)) = ? 
             AND reset_code = ? 
             AND reset_expires > NOW()`,
            [requestedEmail, requestedOtp]
        );

        if (users.length === 0) {
            return res.status(400).json({
                success: false,
                message: "Invalid or expired reset code. Please request a new code."
            });
        }

        const hashedPassword = await bcrypt.hash(newPassword, 10);

        await db.query(
            "UPDATE users SET password = ?, reset_code = NULL, reset_expires = NULL WHERE id = ?",
            [hashedPassword, users[0].id]
        );

        return res.status(200).json({
            success: true,
            message: "Password updated successfully. You can now sign in."
        });
    } catch (error) {
        console.error("Reset user password error:", error);
        return res.status(500).json({
            success: false,
            message: "Failed to reset password."
        });
    }
};

exports.setupAdminAuth = async () => {
    await ensureAdminAuthTable();
};