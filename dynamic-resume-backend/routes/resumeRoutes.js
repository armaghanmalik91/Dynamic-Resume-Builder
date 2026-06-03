const express = require("express");
const router = express.Router();

const {
    createResumeDraft,
    updateResumeMode,
    updateContactInfo,
    getResume,
    getEducation,
    saveEducation,
    updateResumeTemplate,
    saveWorkHistory
} = require("../controllers/resumeController");

const authMiddleware = require("../middleware/authMiddleware");

// Resume draft create
router.post("/create", authMiddleware, createResumeDraft);

// Resume mode update: upload / scratch
router.post("/update-mode", authMiddleware, updateResumeMode);

// Contact info save/update
router.post("/update-contact", authMiddleware, updateContactInfo);

// Selected template update
router.post("/update-template", authMiddleware, updateResumeTemplate);

// Resume data fetch
router.get("/get/:resume_id", authMiddleware, getResume);

// Education fetch/save
router.get("/education/:resume_id", authMiddleware, getEducation);
router.post("/education", authMiddleware, saveEducation);

// Work history save
router.post("/work-history", authMiddleware, saveWorkHistory);

module.exports = router;