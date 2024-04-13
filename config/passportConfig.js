// config/passportConfig.js
const passport = require('passport');
const LocalStrategy = require('passport-local').Strategy;
const Farmer = require('../models/farmer');

passport.use('farmer', new LocalStrategy(
  function(username, password, done) {
    Farmer.findByUsername(username, (err, user) => {
      if (err) { return done(err); }
      if (!user) { return done(null, false, { message: 'Incorrect username.' }); }
      if (!user.validPassword(password)) { return done(null, false, { message: 'Incorrect password.' }); }
      return done(null, user);
    });
  }
));

// Define customer authentication strategy similarly...
