const db = require("../config/db");

exports.getAllTemplates = async (req, res) => {
    try {
        const [templates] = await db.query(
            `SELECT 
                id, 
                name, 
                category,
                has_photo,
                column_count,
                thumbnail_url, 
                template_key,
                layout_key,
                default_color,
                is_active,
                created_at
            FROM templates 
            WHERE is_active = 1
            ORDER BY id DESC`
        );

        res.status(200).json({
            success: true,
            templates
        });
    } catch (error) {
        console.error("Template Fetch Error:", error);
        res.status(500).json({
            success: false,
            message: "Server error fetching templates.",
            error: error.message
        });
    }
};

exports.uploadTemplate = async (req, res) => {
    try {
        console.log("Template Upload Body:", req.body);
        console.log("Template Upload File:", req.file);

        const {
            name,
            category,
            has_photo,
            column_count,
            layout_key,
            default_color
        } = req.body;

        if (!name || !category) {
            return res.status(400).json({
                success: false,
                message: "Template name and category are required."
            });
        }

        if (!req.file) {
            return res.status(400).json({
                success: false,
                message: "Template image is required."
            });
        }

        const finalHasPhoto = Number(has_photo) === 1 ? 1 : 0;
        const finalColumnCount = Number(column_count) === 1 ? 1 : 2;
        const finalLayoutKey = layout_key || "modern_sidebar";
        const finalDefaultColor = default_color || "#2563eb";

        const thumbnailUrl = `/uploads/templates/${req.file.filename}`;
        const templateKey = `template_${Date.now()}`;

        const [result] = await db.query(
            `INSERT INTO templates 
                (
                    name, 
                    category, 
                    has_photo,
                    column_count,
                    thumbnail_url, 
                    template_key,
                    layout_key,
                    default_color,
                    is_active
                ) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)`,
            [
                name,
                category,
                finalHasPhoto,
                finalColumnCount,
                thumbnailUrl,
                templateKey,
                finalLayoutKey,
                finalDefaultColor,
                1
            ]
        );

        res.status(201).json({
            success: true,
            message: "Template uploaded successfully.",
            template: {
                id: result.insertId,
                name,
                category,
                has_photo: finalHasPhoto,
                column_count: finalColumnCount,
                thumbnail_url: thumbnailUrl,
                template_key: templateKey,
                layout_key: finalLayoutKey,
                default_color: finalDefaultColor,
                is_active: 1
            }
        });
    } catch (error) {
        console.error("Template Upload Error:", error);

        res.status(500).json({
            success: false,
            message: "Server error uploading template.",
            error: error.message
        });
    }
};