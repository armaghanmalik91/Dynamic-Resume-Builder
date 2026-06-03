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

// IMPORTANT: setupAdminAuth yahan import hona chahiye, call se pehle
const { setupAdminAuth } = require("./controllers/authController");

const app = express();

app.use(cors());
app.use(express.json());
app.use("/uploads", express.static(path.join(__dirname, "uploads")));

// Routes
app.use("/api", authRoutes);
app.use("/api/resumes", resumeRoutes);
app.use("/api/templates", templateRoutes);
app.use("/api/jobs", jobRoutes);
app.use("/uploads", express.static("uploads"));

app.get("/", (req, res) => {
    res.status(200).json({
        success: true,
        message: "Dynamic Resume Builder backend is running."
    });
});

app.get("/api/test-db", async (req, res) => {
    try {
        const [rows] = await db.query("SHOW TABLES");

        res.status(200).json({
            success: true,
            message: "Database connected successfully! 🎉",
            tables: rows
        });
    } catch (error) {
        console.error("Database connection error:", error);

        res.status(500).json({
            success: false,
            message: "Database connection failed!"
        });
    }
});

const PORT = process.env.PORT || 5000;

async function startServer() {
    try {
        await setupAdminAuth();
        console.log("✅ Admin auth table checked/created");

        app.listen(PORT, () => {
            console.log(`✅ Backend Server is running on http://localhost:${PORT}`);
            console.log(`🔍 Test DB connection at: http://localhost:${PORT}/api/test-db`);
        });
    } catch (error) {
        console.error("❌ Server startup failed:", error);
    }
}

startServer();