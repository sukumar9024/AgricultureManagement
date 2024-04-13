const express = require('express');
const router = express.Router();
const passport = require('../config/passportConfig');
const isAuthenticated = require('../middleware/isAuthenticated');

// Import controllers
const indexController = require('../controllers/indexcontroller');

// Define routes
router.get('/', indexController.getIndexPage);
router.get('/login', indexController.getLoginPage);
router.get('/customer-login', indexController.getCustomerLoginPage);
router.get('/customer-register', indexController.getCustomerRegisterPage);
router.get('/farmer-login', indexController.getFarmerLoginPage);
router.get('/farmer-register', indexController.getFarmerRegisterPage);


// Login routes
router.post('/login/customer', passport.authenticate('customer', {
  successRedirect: '/customer/profile', // Redirect to customer profile
  failureRedirect: '/customer/login', // Redirect to customer login page on failure
  failureFlash: true
}));

router.post('/login/farmer', passport.authenticate('farmer', {
  successRedirect: '/farmer/profile', // Redirect to farmer profile
  failureRedirect: '/farmer/login', // Redirect to farmer login page on failure
  failureFlash: true
}));

// Profile routes
router.get('/customer/profile', isAuthenticated, (req, res) => {
  res.send('Welcome to customer profile');
});

router.get('/farmer/profile', isAuthenticated, (req, res) => {
  res.send('Welcome to farmer profile');
});

// Define other routes...

module.exports = router;
