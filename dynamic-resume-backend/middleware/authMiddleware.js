const jwt = require('jsonwebtoken');

module.exports = (req, res, next) => {
    // Frontend se token header mein aayega
    const authHeader = req.header('Authorization');
    if (!authHeader) return res.status(401).json({ success: false, message: 'Access Denied. No token provided.' });

    const token = authHeader.split(' ')[1]; // "Bearer TOKEN" se token nikalna
    if (!token) return res.status(401).json({ success: false, message: 'Access Denied. Invalid token format.' });

    try {
        const verified = jwt.verify(token, process.env.JWT_SECRET);
        req.user = verified; // User ki ID aur Email request mein save kar li
        next(); // Agle function par jao
    } catch (error) {
        res.status(400).json({ success: false, message: 'Invalid or expired token.' });
    }
};