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
            message: "resume_id is required"
        });
    }

    const finalJobTitle = job_title || title || null;
    const finalEmployer = employer || null;

    let finalCity = city || null;
    let finalCountry = country || null;

    if ((!finalCity || !finalCountry) && location) {
        const parts = String(location).split(",");
        finalCity = finalCity || (parts[0] ? parts[0].trim() : null);
        finalCountry = finalCountry || (parts[1] ? parts[1].trim() : null);
    }

    const finalRemote = is_remote || remote ? 1 : 0;
    const finalCurrentlyWorking = currently_working || currently_work_here ? 1 : 0;

    try {
        /*
            Duplicate prevention:
            Same resume_id + same job_title + same employer + same city + same start/end dates
            already exists ho to new INSERT nahi karega.
        */
        const [existingRows] = await db.query(
            `
            SELECT id FROM work_history
            WHERE resume_id = ?
              AND COALESCE(job_title, '') = COALESCE(?, '')
              AND COALESCE(employer, '') = COALESCE(?, '')
              AND COALESCE(city, '') = COALESCE(?, '')
              AND COALESCE(country, '') = COALESCE(?, '')
              AND COALESCE(start_month, '') = COALESCE(?, '')
              AND COALESCE(start_year, '') = COALESCE(?, '')
              AND COALESCE(end_month, '') = COALESCE(?, '')
              AND COALESCE(end_year, '') = COALESCE(?, '')
            LIMIT 1
            `,
            [
                resume_id,
                finalJobTitle,
                finalEmployer,
                finalCity,
                finalCountry,
                start_month || null,
                start_year || null,
                end_month || null,
                end_year || null
            ]
        );

        if (existingRows.length > 0) {
            const existingId = existingRows[0].id;

            await db.query(
                `
                UPDATE work_history
                SET
                    job_title = ?,
                    employer = ?,
                    city = ?,
                    country = ?,
                    is_remote = ?,
                    start_month = ?,
                    start_year = ?,
                    end_month = ?,
                    end_year = ?,
                    currently_working = ?,
                    reason = ?,
                    updated_at = NOW()
                WHERE id = ?
                `,
                [
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
                    reason || null,
                    existingId
                ]
            );

            return res.status(200).json({
                success: true,
                message: "Work history updated successfully",
                work_history_id: existingId,
                duplicate_prevented: true
            });
        }

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
            message: "Work history saved successfully",
            work_history_id: result.insertId,
            duplicate_prevented: false
        });
    } catch (error) {
        console.error("Work history save error:", error);

        return res.status(500).json({
            success: false,
            message: "Database error while saving work history"
        });
    }
};

// Get Skills Data
exports.getSkills = async (req, res) => {
    const { resume_id } = req.params;

    try {
        const [skills] = await db.query(
            "SELECT * FROM resume_skills WHERE resume_id = ? ORDER BY id ASC",
            [resume_id]
        );

        return res.status(200).json({
            success: true,
            skills
        });
    } catch (error) {
        console.error("Get Skills Error:", error);

        return res.status(500).json({
            success: false,
            message: "Server error while fetching skills."
        });
    }
};

// Save or Update Skills Data
exports.saveSkills = async (req, res) => {
    const { resume_id, skills } = req.body;

    try {
        if (!resume_id) {
            return res.status(400).json({
                success: false,
                message: "Resume ID is required."
            });
        }

        if (!Array.isArray(skills)) {
            return res.status(400).json({
                success: false,
                message: "Skills must be an array."
            });
        }

        await db.query("DELETE FROM resume_skills WHERE resume_id = ?", [resume_id]);

        const cleanSkills = skills
            .map(skill => ({
                skill_name: String(skill.skill_name || "").trim(),
                skill_level: String(skill.skill_level || "").trim()
            }))
            .filter(skill => skill.skill_name !== "");

        if (cleanSkills.length > 0) {
            const values = cleanSkills.map(skill => [
                resume_id,
                skill.skill_name,
                skill.skill_level || null
            ]);

            await db.query(
                "INSERT INTO resume_skills (resume_id, skill_name, skill_level) VALUES ?",
                [values]
            );
        }

        return res.status(200).json({
            success: true,
            message: "Skills saved successfully!",
            skills: cleanSkills
        });
    } catch (error) {
        console.error("Save Skills Error:", error);

        return res.status(500).json({
            success: false,
            message: "Server error while saving skills."
        });
    }
};

// ================= SUMMARY CONTROLLERS =================

// Get Summary Data
exports.getSummary = async (req, res) => {
    const { resume_id } = req.params;

    try {
        if (!resume_id) {
            return res.status(400).json({
                success: false,
                message: "Resume ID is required."
            });
        }

        const [rows] = await db.query(
            "SELECT * FROM resume_summaries WHERE resume_id = ? LIMIT 1",
            [resume_id]
        );

        return res.status(200).json({
            success: true,
            summary: rows.length > 0 ? rows[0] : null
        });
    } catch (error) {
        console.error("Get Summary Error:", error);

        return res.status(500).json({
            success: false,
            message: "Server error while fetching summary."
        });
    }
};

// Save or Update Summary Data
exports.saveSummary = async (req, res) => {
    const { resume_id, summary_text } = req.body;

    try {
        if (!resume_id) {
            return res.status(400).json({
                success: false,
                message: "Resume ID is required."
            });
        }

        await db.query(
            `
            INSERT INTO resume_summaries (resume_id, summary_text)
            VALUES (?, ?)
            ON DUPLICATE KEY UPDATE
                summary_text = VALUES(summary_text),
                updated_at = CURRENT_TIMESTAMP
            `,
            [
                resume_id,
                summary_text || ""
            ]
        );

        return res.status(200).json({
            success: true,
            message: "Summary saved successfully!"
        });
    } catch (error) {
        console.error("Save Summary Error:", error);

        return res.status(500).json({
            success: false,
            message: "Server error while saving summary."
        });
    }
};

// ================= FINALIZE CONTROLLERS =================

// Get Finalize Snapshot
exports.getFinalizeSnapshot = async (req, res) => {
    const { resume_id } = req.params;
    const userId = req.user.id;

    try {
        if (!resume_id) {
            return res.status(400).json({
                success: false,
                message: "Resume ID is required."
            });
        }

        const [resumeRows] = await db.query(
            "SELECT id FROM resumes WHERE id = ? AND user_id = ? LIMIT 1",
            [resume_id, userId]
        );

        if (resumeRows.length === 0) {
            return res.status(404).json({
                success: false,
                message: "Resume not found or access denied."
            });
        }

        const [rows] = await db.query(
            "SELECT * FROM resume_final_snapshots WHERE resume_id = ? LIMIT 1",
            [resume_id]
        );

        if (rows.length === 0) {
            return res.status(200).json({
                success: true,
                final_snapshot: null
            });
        }

        const row = rows[0];

        const parseJson = (value, fallback) => {
            try {
                if (!value) return fallback;
                if (typeof value === "object") return value;
                return JSON.parse(value);
            } catch (error) {
                return fallback;
            }
        };

        return res.status(200).json({
            success: true,
            final_snapshot: {
                id: row.id,
                resume_id: row.resume_id,
                selected_sections: parseJson(row.selected_sections, []),
                contact_data: parseJson(row.contact_data, {}),
                work_history_data: parseJson(row.work_history_data, []),
                education_data: parseJson(row.education_data, {}),
                skills_data: parseJson(row.skills_data, []),
                summary_data: parseJson(row.summary_data, {}),
                template_data: parseJson(row.template_data, {}),
                final_resume_data: parseJson(row.final_resume_data, {}),
                created_at: row.created_at,
                updated_at: row.updated_at
            }
        });
    } catch (error) {
        console.error("Get Finalize Snapshot Error:", error);

        return res.status(500).json({
            success: false,
            message: "Server error while fetching finalize snapshot."
        });
    }
};

// Save or Update Finalize Snapshot
exports.saveFinalizeSnapshot = async (req, res) => {
    const {
        resume_id,
        selected_sections,
        contact_data,
        work_history_data,
        education_data,
        skills_data,
        summary_data,
        template_data,
        final_resume_data
    } = req.body;

    const userId = req.user.id;

    try {
        if (!resume_id) {
            return res.status(400).json({
                success: false,
                message: "Resume ID is required."
            });
        }

        const [resumeRows] = await db.query(
            "SELECT id FROM resumes WHERE id = ? AND user_id = ? LIMIT 1",
            [resume_id, userId]
        );

        if (resumeRows.length === 0) {
            return res.status(404).json({
                success: false,
                message: "Resume not found or access denied."
            });
        }

        const safeStringify = (value, fallback) => {
            try {
                if (value === undefined || value === null) {
                    return JSON.stringify(fallback);
                }
                return JSON.stringify(value);
            } catch (error) {
                return JSON.stringify(fallback);
            }
        };

        const finalSelectedSections = Array.isArray(selected_sections)
            ? selected_sections
            : [];

        const finalContactData = contact_data || {};
        const finalWorkHistoryData = Array.isArray(work_history_data)
            ? work_history_data
            : [];
        const finalEducationData = education_data || {};
        const finalSkillsData = Array.isArray(skills_data)
            ? skills_data
            : [];
        const finalSummaryData = summary_data || {};
        const finalTemplateData = template_data || {};

        const finalResumeData = final_resume_data || {
            contact: finalContactData,
            work_history: finalWorkHistoryData,
            education: finalEducationData,
            skills: finalSkillsData,
            summary: finalSummaryData,
            selected_sections: finalSelectedSections,
            template: finalTemplateData
        };

        await db.query(
            `
            INSERT INTO resume_final_snapshots
            (
                resume_id,
                selected_sections,
                contact_data,
                work_history_data,
                education_data,
                skills_data,
                summary_data,
                template_data,
                final_resume_data
            )
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
            ON DUPLICATE KEY UPDATE
                selected_sections = VALUES(selected_sections),
                contact_data = VALUES(contact_data),
                work_history_data = VALUES(work_history_data),
                education_data = VALUES(education_data),
                skills_data = VALUES(skills_data),
                summary_data = VALUES(summary_data),
                template_data = VALUES(template_data),
                final_resume_data = VALUES(final_resume_data),
                updated_at = CURRENT_TIMESTAMP
            `,
            [
                resume_id,
                safeStringify(finalSelectedSections, []),
                safeStringify(finalContactData, {}),
                safeStringify(finalWorkHistoryData, []),
                safeStringify(finalEducationData, {}),
                safeStringify(finalSkillsData, []),
                safeStringify(finalSummaryData, {}),
                safeStringify(finalTemplateData, {}),
                safeStringify(finalResumeData, {})
            ]
        );

        return res.status(200).json({
            success: true,
            message: "Final resume snapshot saved successfully!",
            final_resume_data: finalResumeData
        });
    } catch (error) {
        console.error("Save Finalize Snapshot Error:", error);

        return res.status(500).json({
            success: false,
            message: "Server error while saving finalize snapshot."
        });
    }
};