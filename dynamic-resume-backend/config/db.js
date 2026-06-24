// config/db.js
const mysql = require("mysql2");
require("dotenv").config();

const pool = mysql.createPool({
  host: process.env.DB_HOST || "127.0.0.1",
  user: process.env.DB_USER || "root",
  password: process.env.DB_PASSWORD || "",
  database: process.env.DB_NAME || "dynamic_resume_db",
  port: Number(process.env.DB_PORT || 3308),
  waitForConnections: true,
  connectionLimit: 10,
  queueLimit: 0,
  ssl: {
    rejectUnauthorized: false // Yeh line Aiven cloud database ke liye lazmi hai
  }
});

const promisePool = pool.promise();

module.exports = promisePool;