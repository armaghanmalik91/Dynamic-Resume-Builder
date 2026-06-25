// server.js
const express = require("express");
const cors = require("cors");
const path = require("path");
require("dotenv").config();

const db = require("./config/db");

const authRoutes = require("./routes/authRoutes");
const resumeRoutes = require("./routes/resumeRoutes");
const templateRoutes = require("./routes/templateRoutes");
const jobRoutes = require("./routes/jobRoutes");

const { setupAdminAuth } = require("./controllers/authController");

const app = express();

const PORT = process.env.PORT || 5000;

// Middleware
// Middleware
app.use(cors({
    origin: [
        'https://resume-frontend-3rrg.onrender.com', // Aapka Live Frontend URL
        'http://localhost:3000',                     // Local development ke liye (safe side)
        'http://localhost:8000'                     // Laravel local server ke liye
    ],
    credentials: true,
    methods: ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS'],
    allowedHeaders: ['Content-Type', 'Authorization']
}));
app.use(express.json({ limit: "10mb" }));
app.use(express.urlencoded({ extended: true }));

// Static uploads folder
app.use("/uploads", express.static(path.join(__dirname, "uploads")));

// API routes
app.use("/api", authRoutes);
app.use("/api/resumes", resumeRoutes);
app.use("/api/templates", templateRoutes);
app.use("/api/jobs", jobRoutes);

// Health route
app.get("/", (req, res) => {
    res.status(200).json({
        success: true,
        message: "Dynamic Resume Builder backend is running."
    });
});

// DB test route
app.get("/api/test-db", async (req, res) => {
    try {
        const [rows] = await db.query("SHOW TABLES");

        res.status(200).json({
            success: true,
            message: "Database connected successfully!",
            tables: rows
        });
    } catch (error) {
        console.error("Database connection error:", error);

        res.status(500).json({
            success: false,
            message: "Database connection failed!",
            error: error.message
        });
    }
});

async function startServer() {
    try {
        await setupAdminAuth();
        console.log("✅ Admin auth table checked/created");

        app.listen(PORT, () => {
            console.log(`✅ Backend Server is running on port ${PORT}`);
            console.log(`🔍 Test DB connection at: /api/test-db`);
        });
    } catch (error) {
        console.error("❌ Server startup failed:", error);
        process.exit(1);
    }
}

startServer();