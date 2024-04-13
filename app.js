const express = require('express');
const session = require('express-session');
const passport = require('./config/passportConfig');
const path = require('path');

const app = express();

// Middleware setup
app.use(express.urlencoded({ extended: true }));
app.use(session({
  secret: 'secret',
  resave: false,
  saveUninitialized: false
}));
app.use(passport.initialize());
app.use(passport.session());

// Serve static files from the 'public' directory
app.use(express.static(path.join(__dirname, 'public')));

// Serve static HTML files from the 'views' directory
app.use(express.static(path.join(__dirname, 'views')));

// Start the server
const PORT = process.env.PORT || 3000;
app.listen(PORT, () => {
  console.log(`Server is running on port ${PORT}`);
});
