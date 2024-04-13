const express = require('express');
const bodyParser = require('body-parser');
const mysql = require('mysql');

const app = express();

// Create connection pool
const pool = mysql.createPool({
    connectionLimit: 10,
    host: 'localhost',
    user: 'root', // Your MySQL username
    password: '', // Your MySQL password
    database: 'farmers' // Your MySQL database name
});

// Middleware
app.use(bodyParser.urlencoded({ extended: false }));
app.use(bodyParser.json());

// Login route
app.post('/login', (req, res) => {
    const { email, password } = req.body;

    pool.query('SELECT * FROM farmers_data WHERE email = ? AND password = ?', [email, password], (error, results) => {
        if (error) {
            return res.status(500).json({ message: 'Internal server error' });
        }

        if (results.length === 1) {
            // Redirect to index.html if login is successful
            res.redirect('./index.html');
        } else {
            // Redirect back to the login page with an error message
            res.redirect('/customer_login.html?error=1');
        }
    });
});

const PORT = 3000;
app.listen(PORT, () => console.log(`Server running on port ${PORT}`));
