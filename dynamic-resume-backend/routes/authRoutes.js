const express = require("express");
const router = express.Router();

const {
    register,
    login,
    verifyOTP,
    googleLogin,
    getUserProfile,
    updateOnboarding,
    forgotUserPassword,
    verifyUserResetCode,
    resetUserPassword,
    adminLogin,
    forgotAdminPassword,
    verifyAdminResetCode,
    resetAdminPassword
} = require("../controllers/authController");

const authMiddleware = require("../middleware/authMiddleware");

// User Auth Routes
router.post("/auth/register", register);
router.post("/auth/login", login);
router.post("/auth/verify-otp", verifyOTP);
router.post("/auth/google", googleLogin);
router.post("/auth/forgot-password", forgotUserPassword);
router.post("/auth/verify-reset-code", verifyUserResetCode);
router.post("/auth/reset-password", resetUserPassword);

// User Protected Routes
router.get("/auth/profile", authMiddleware, getUserProfile);
router.post("/auth/onboarding", authMiddleware, updateOnboarding);

// Admin Auth Routes
router.post("/admin/auth/login", adminLogin);
router.post("/admin/auth/forgot-key", forgotAdminPassword);
router.post("/admin/auth/verify-key", verifyAdminResetCode);
router.post("/admin/auth/reset-key", resetAdminPassword);

module.exports = router;
