// Import any dependencies you need
const path = require('path');

// Define controller functions
const indexController = {
  getIndexPage: (req, res) => {
    res.sendFile(path.join(__dirname, '..', 'views', 'index.html'));
  },
  getLoginPage: (req, res) => {
    res.sendFile(path.join(__dirname, '..', 'views', 'login.html'));
  },
  getCustomerLoginPage: (req, res) => {
    res.sendFile(path.join(__dirname, '..', 'views', 'customer_login.html'));
  },
  getCustomerRegisterPage: (req, res) => {
    res.sendFile(path.join(__dirname, '..', 'views', 'customer_register.html'));
  },
  getFarmerLoginPage: (req, res) => {
    res.sendFile(path.join(__dirname, '..', 'views', 'farmer_login.html'));
  },
  getFarmerRegisterPage: (req, res) => {
    res.sendFile(path.join(__dirname, '..', 'views', 'farmer_register.html'));
  }
};

module.exports = indexController;
