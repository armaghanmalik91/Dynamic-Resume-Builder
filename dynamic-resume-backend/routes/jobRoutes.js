const express = require('express');
const router = express.Router();
// Purani searchJobs ke sath baki controller functions ko bhi yahan destructure kar liya gaya hai
const { searchJobs, toggleSaveJob, applyJob, getUserJobMetric } = require('../controllers/jobController');
const authMiddleware = require('../middleware/authMiddleware');

// Purana route (un-touched)
router.get('/search', authMiddleware, searchJobs);

// Naye routes bina kisi chech-chaar ke niche add kar diye hain
router.post('/save', authMiddleware, toggleSaveJob);
router.post('/apply', authMiddleware, applyJob);
router.get('/metrics', authMiddleware, getUserJobMetric);

module.exports = router;