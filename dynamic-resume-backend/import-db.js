const fs = require('fs');
const mysql = require('mysql2');

const connection = mysql.createConnection({
  host: 'mysql-7663822-dynamicresume051.h.aivencloud.com',
  port: 25293,
  user: 'avnadmin',
  // Line number 8 ko aisa kar dein:
  password: process.env.DB_PASSWORD,
  database: 'defaultdb',
  multipleStatements: true
  
});

const sqlFilePath = 'C:\\Users\\Armaghan\\Downloads\\dynamic_resume_db (3).sql';

console.log('Reading SQL file...');
let sql = fs.readFileSync(sqlFilePath, 'utf8');

// Sabse shuru me Primary Key ki restriction off karenge aur aakhir me on karenge
const finalSql = `
  SET SESSION sql_require_primary_key = 0;
  SET FOREIGN_KEY_CHECKS = 0;
  ${sql}
  SET FOREIGN_KEY_CHECKS = 1;
  SET SESSION sql_require_primary_key = 1;
`;

// Purane tables ko saaf karne ki query
const dropTablesQuery = `
  SET FOREIGN_KEY_CHECKS = 0;
  DROP TABLE IF EXISTS \`user_saved_jobs\`;
  DROP TABLE IF EXISTS \`user_applied_jobs\`;
  DROP TABLE IF EXISTS \`work_history\`;
  DROP TABLE IF EXISTS \`resume_final_snapshots\`;
  DROP TABLE IF EXISTS \`resume_skills\`;
  DROP TABLE IF EXISTS \`resume_summaries\`;
  DROP TABLE IF EXISTS \`education\`;
  DROP TABLE IF EXISTS \`experience\`;
  DROP TABLE IF EXISTS \`resumes\`;
  DROP TABLE IF EXISTS \`jobs\`;
  DROP TABLE IF EXISTS \`templates\`;
  DROP TABLE IF EXISTS \`users\`;
  DROP TABLE IF EXISTS \`admin_auth\`;
  SET FOREIGN_KEY_CHECKS = 1;
`;

console.log('Connecting to Aiven.io...');
connection.connect((err) => {
  if (err) {
    console.error('Database connection failed:', err.stack);
    return;
  }
  
  console.log('Cleaning old tables...');
  connection.query(dropTablesQuery, (dropError) => {
    if (dropError) {
      console.error('Error cleaning old tables:', dropError);
      connection.end();
      return;
    }
    
    console.log('Creating fresh tables and importing data (Bypass PK check)...');
    connection.query(finalSql, (error, results) => {
      if (error) {
        console.error('Error executing SQL file:', error);
      } else {
        console.log('🎉 Booom! Saare tables successfully Aiven database me ban chuke hain!');
      }
      connection.end();
    });
  });
});