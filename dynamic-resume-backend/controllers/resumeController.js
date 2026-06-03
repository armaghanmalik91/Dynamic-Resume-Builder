const db = require("../config/db");

// Create Resume Draft
exports.createResumeDraft = async (req, res) => {
    const { template_id } = req.body;
    const userId = req.user.id;

    try {
        const selectedTemplate = template_id || null;

        const [result] = await db.query(
            "INSERT INTO resumes (user_id, title, summary, template_id) VALUES (?, ?, ?, ?)",
            [userId, "My Untitled Resume", "", selectedTemplate]
        );

        return res.status(201).json({
            success: true,
            message: "Resume draft created!",
            resume_id: result.insertId,
            template_id: selectedTemplate
        });
    } catch (error) {
        console.error("Error creating resume:", error);

        return res.status(500).json({
            success: false,
            message: "Server error while creating resume."
        });
    }
};

// Update Resume Creation Mode
exports.updateResumeMode = async (req, res) => {
    const { resume_id, mode } = req.body;
    const userId = req.user.id;

    try {
        if (!resume_id || !mode) {
            return res.status(400).json({
                success: false,
                message: "Resume ID and mode are required."
            });
        }

        await db.query(
            "UPDATE resumes SET creation_mode = ? WHERE id = ? AND user_id = ?",
            [mode, resume_id, userId]
        );

        return res.status(200).json({
            success: true,
            message: "Creation mode updated successfully!"
        });
    } catch (error) {
        console.error("Mode Update Error:", error);

        return res.status(500).json({
            success: false,
            message: "Server error while updating resume mode."
        });
    }
};

// Update Resume Contact Info
exports.updateContactInfo = async (req, res) => {
    const {
        resume_id,
        first_name,
        last_name,
        phone,
        email,
        city,
        country,
        postal_code
    } = req.body;

    const userId = req.user.id;

    try {
        if (!resume_id) {
            return res.status(400).json({
                success: false,
                message: "Resume ID is required."
            });
        }

        await db.query(
            `UPDATE resumes 
             SET first_name = ?, 
                 last_name = ?, 
                 phone = ?, 
                 email = ?, 
                 city = ?, 
                 country = ?, 
                 postal_code = ?
             WHERE id = ? AND user_id = ?`,
            [
                first_name || "",
                last_name || "",
                phone || "",
                email || "",
                city || "",
                country || "",
                postal_code || "",
                resume_id,
                userId
            ]
        );

        return res.status(200).json({
            success: true,
            message: "Contact info saved successfully!"
        });
    } catch (error) {
        console.error("Contact Update Error:", error);

        return res.status(500).json({
            success: false,
            message: "Server error while saving contact info."
        });
    }
};

// Get Resume With Selected Template
exports.getResume = async (req, res) => {
    const { resume_id } = req.params;
    const userId = req.user.id;

    try {
        const [resumes] = await db.query(
            `SELECT 
                r.*,
                t.name AS template_name,
                t.category AS template_category,
                t.thumbnail_url AS template_thumbnail_url,
                t.template_key AS template_key
             FROM resumes r
             LEFT JOIN templates t 
                ON r.template_id = t.template_key 
                OR r.template_id = CAST(t.id AS CHAR)
             WHERE r.id = ? AND r.user_id = ?`,
            [resume_id, userId]
        );

        if (resumes.length === 0) {
            return res.status(404).json({
                success: false,
                message: "Resume not found."
            });
        }

        return res.status(200).json({
            success: true,
            resume: resumes[0]
        });
    } catch (error) {
        console.error("Get Resume Error:", error);

        return res.status(500).json({
            success: false,
            message: "Server error while fetching resume."
        });
    }
};

// Get Education Data
exports.getEducation = async (req, res) => {
    const { resume_id } = req.params;

    try {
        const [education] = await db.query(
            "SELECT * FROM education WHERE resume_id = ?",
            [resume_id]
        );

        return res.status(200).json({
            success: true,
            education: education[0] || null
        });
    } catch (error) {
        console.error("Get Education Error:", error);

        return res.status(500).json({
            success: false,
            message: "Server error while fetching education."
        });
    }
};

// Save or Update Education Data
exports.saveEducation = async (req, res) => {
    const {
        resume_id,
        school_name,
        school_location,
        degree,
        field_of_study,
        graduation_month,
        graduation_year
    } = req.body;

    try {
        if (!resume_id) {
            return res.status(400).json({
                success: false,
                message: "Resume ID is required."
            });
        }

        const [existing] = await db.query(
            "SELECT id FROM education WHERE resume_id = ?",
            [resume_id]
        );

        if (existing.length > 0) {
            await db.query(
                `UPDATE education 
                 SET school_name = ?, 
                     school_location = ?, 
                     degree = ?, 
                     field_of_study = ?, 
                     graduation_month = ?, 
                     graduation_year = ?
                 WHERE resume_id = ?`,
                [
                    school_name || "",
                    school_location || "",
                    degree || "",
                    field_of_study || "",
                    graduation_month || "",
                    graduation_year || "",
                    resume_id
                ]
            );
        } else {
            await db.query(
                `INSERT INTO education 
                    (resume_id, school_name, school_location, degree, field_of_study, graduation_month, graduation_year) 
                 VALUES (?, ?, ?, ?, ?, ?, ?)`,
                [
                    resume_id,
                    school_name || "",
                    school_location || "",
                    degree || "",
                    field_of_study || "",
                    graduation_month || "",
                    graduation_year || ""
                ]
            );
        }

        return res.status(200).json({
            success: true,
            message: "Education saved successfully!"
        });
    } catch (error) {
        console.error("Save Education Error:", error);

        return res.status(500).json({
            success: false,
            message: "Server error while saving education."
        });
    }
};

// Update Selected Resume Template
exports.updateResumeTemplate = async (req, res) => {
    const { resume_id, template_id } = req.body;
    const userId = req.user.id;

    try {
        if (!resume_id || !template_id) {
            return res.status(400).json({
                success: false,
                message: "Resume ID and Template ID are required."
            });
        }

        const [templateRows] = await db.query(
            `SELECT id, name, category, thumbnail_url, template_key 
             FROM templates 
             WHERE template_key = ? OR id = ?
             LIMIT 1`,
            [template_id, template_id]
        );

        if (templateRows.length === 0) {
            return res.status(404).json({
                success: false,
                message: "Selected template not found."
            });
        }

        const finalTemplateKey = templateRows[0].template_key || String(templateRows[0].id);

        await db.query(
            "UPDATE resumes SET template_id = ? WHERE id = ? AND user_id = ?",
            [finalTemplateKey, resume_id, userId]
        );

        const [rows] = await db.query(
            `SELECT 
                r.*,
                t.name AS template_name,
                t.category AS template_category,
                t.thumbnail_url AS template_thumbnail_url,
                t.template_key AS template_key
             FROM resumes r
             LEFT JOIN templates t
                ON r.template_id = t.template_key 
                OR r.template_id = CAST(t.id AS CHAR)
             WHERE r.id = ? AND r.user_id = ?`,
            [resume_id, userId]
        );

        return res.status(200).json({
            success: true,
            message: "Template updated successfully.",
            resume: rows[0]
        });
    } catch (error) {
        console.error("Template Update Error:", error);

        return res.status(500).json({
            success: false,
            message: "Server error while updating template."
        });
    }
};

exports.saveWorkHistory = async (req, res) => {
    const {
        resume_id,
        job_title,
        title,
        employer,
        city,
        country,
        location,
        is_remote,
        remote,
        start_month,
        start_year,
        end_month,
        end_year,
        currently_working,
        currently_work_here,
        reason
    } = req.body;

    if (!resume_id) {
        return res.status(400).json({
            success: false,
            message: 'resume_id is required'
        });
    }

    const finalJobTitle = job_title || title || null;
    const finalEmployer = employer || null;

    let finalCity = city || null;
    let finalCountry = country || null;

    if ((!finalCity || !finalCountry) && location) {
        const parts = String(location).split(',');
        finalCity = finalCity || (parts[0] ? parts[0].trim() : null);
        finalCountry = finalCountry || (parts[1] ? parts[1].trim() : null);
    }

    const finalRemote = is_remote || remote ? 1 : 0;
    const finalCurrentlyWorking = currently_working || currently_work_here ? 1 : 0;

    try {
        const [result] = await db.query(
            `
            INSERT INTO work_history
            (
                resume_id,
                job_title,
                employer,
                city,
                country,
                is_remote,
                start_month,
                start_year,
                end_month,
                end_year,
                currently_working,
                reason
            )
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            `,
            [
                resume_id,
                finalJobTitle,
                finalEmployer,
                finalCity,
                finalCountry,
                finalRemote,
                start_month || null,
                start_year || null,
                end_month || null,
                end_year || null,
                finalCurrentlyWorking,
                reason || null
            ]
        );

        return res.status(200).json({
            success: true,
            message: 'Work history saved successfully',
            work_history_id: result.insertId
        });
    } catch (error) {
        console.error('Work history save error:', error);
        return res.status(500).json({
            success: false,
            message: 'Database error while saving work history'
        });
    }
};