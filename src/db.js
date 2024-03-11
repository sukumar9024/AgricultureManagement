const mysql = require('mysql');

// Create a connection pool to the database
const pool = mysql.createPool({
  connectionLimit: 10,
  host: 'localhost',
  user: 'root',
  password: '',
  database: 'farming'
});

module.exports = pool;
