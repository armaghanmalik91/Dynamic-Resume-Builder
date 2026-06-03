const db = require('../config/db');

// --- Updated Advanced Search Logic with Pagination ---
exports.searchJobs = async (req, res) => {
    const { keyword, location, distance, timeRange, sortBy, page } = req.query;
    
    // Pagination defaults (Professional standard)
    const limit = 4; // Har page pr 4 jobs show hongi jaisa design me ha
    const offset = page ? (parseInt(page) - 1) * limit : 0;

    try {
        let query = 'SELECT * FROM jobs WHERE 1=1';
        const params = [];

        // 1. Keyword Filter
        if (keyword && keyword.trim() !== '') {
            query += ' AND (title LIKE ? OR description LIKE ?)';
            params.push(`%${keyword}%`, `%${keyword}%`);
        }

        // 2. Location Filter
        if (location && location.trim() !== '') {
            query += ' AND location LIKE ?';
            params.push(`%${location}%`);
        }

        // 3. Time Range Filter (Any time, Past day, Past week, Past month)
        if (timeRange && timeRange !== 'Any time') {
            if (timeRange === 'Past day') {
                query += ' AND created_at >= NOW() - INTERVAL 1 DAY';
            } else if (timeRange === 'Past week') {
                query += ' AND created_at >= NOW() - INTERVAL 7 DAY';
            } else if (timeRange === 'Past month') {
                query += ' AND created_at >= NOW() - INTERVAL 30 DAY';
            }
        }

        // 4. Sort By Logic
        if (sortBy === 'Date Posted') {
            query += ' ORDER BY created_at DESC, id DESC';
        } else {
            query += ' ORDER BY id DESC'; // Default: Relevance (ID base)
        }

        // Total Count query for dynamic pagination links
        let countQuery = query.replace('SELECT * FROM jobs', 'SELECT COUNT(*) as total FROM jobs');
        const [totalCountResult] = await db.query(countQuery, params);
        const totalJobs = totalCountResult[0].total;
        const totalPages = Math.ceil(totalJobs / limit);

        // Append Pagination Limits
        query += ' LIMIT ? OFFSET ?';
        params.push(limit, offset);

        const [jobs] = await db.query(query, params);
        
        res.status(200).json({ 
            success: true, 
            jobs, 
            pagination: {
                totalJobs,
                totalPages,
                currentPage: page ? parseInt(page) : 1
            }
        });
    } catch (error) {
        console.error("Advanced Job Search Error:", error);
        res.status(500).json({ success: false, message: 'Server error while filtering jobs.' });
    }
};

// --- Old Metrics & Actions Logic (Unchanged & Safe) ---

// Save or Unsave a job
exports.toggleSaveJob = async (req, res) => {
    const { job_id } = req.body;
    const userId = req.user.id;
    try {
        const [existing] = await db.query('SELECT id FROM user_saved_jobs WHERE user_id = ? AND job_id = ?', [userId, job_id]);
        if (existing.length > 0) {
            await db.query('DELETE FROM user_saved_jobs WHERE user_id = ? AND job_id = ?', [userId, job_id]);
            return res.status(200).json({ success: true, isSaved: false, message: 'Job removed from saved list.' });
        } else {
            await db.query('INSERT INTO user_saved_jobs (user_id, job_id) VALUES (?, ?)', [userId, job_id]);
            return res.status(200).json({ success: true, isSaved: true, message: 'Job saved successfully!' });
        }
    } catch (error) {
        res.status(500).json({ success: false, message: 'Database error.' });
    }
};

// Apply to a job
exports.applyJob = async (req, res) => {
    const { job_id } = req.body;
    const userId = req.user.id;
    try {
        const [existing] = await db.query('SELECT id FROM user_applied_jobs WHERE user_id = ? AND job_id = ?', [userId, job_id]);
        if (existing.length > 0) {
            return res.status(400).json({ success: false, message: 'You have already applied for this job.' });
        }
        await db.query('INSERT INTO user_applied_jobs (user_id, job_id) VALUES (?, ?)', [userId, job_id]);
        res.status(200).json({ success: true, message: 'Application submitted successfully!' });
    } catch (error) {
        res.status(500).json({ success: false, message: 'Database error.' });
    }
};

// Get User Specific Counter & Filter Lists
exports.getUserJobMetric = async (req, res) => {
    const userId = req.user.id;
    const { mode } = req.query; // 'search', 'saved', 'applied'
    try {
        const [[{savedCount}]] = await db.query('SELECT COUNT(*) as savedCount FROM user_saved_jobs WHERE user_id = ?', [userId]);
        const [[{appliedCount}]] = await db.query('SELECT COUNT(*) as appliedCount FROM user_applied_jobs WHERE user_id = ?', [userId]);

        let jobsList = [];
        if (mode === 'saved') {
            [jobsList] = await db.query('SELECT jobs.* FROM jobs INNER JOIN user_saved_jobs ON jobs.id = user_saved_jobs.job_id WHERE user_saved_jobs.user_id = ?', [userId]);
        } else if (mode === 'applied') {
            [jobsList] = await db.query('SELECT jobs.* FROM jobs INNER JOIN user_applied_jobs ON jobs.id = user_applied_jobs.job_id WHERE user_applied_jobs.user_id = ?', [userId]);
        }

        res.status(200).json({ success: true, savedCount, appliedCount, jobs: jobsList });
    } catch (error) {
        res.status(500).json({ success: false, message: 'Database error.' });
    }
};