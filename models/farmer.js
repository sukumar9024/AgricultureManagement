// models/farmer.js
const connection = require('../config/mysqlConnection');

const Farmer = {
  findByUsername: (username, callback) => {
    connection.query('SELECT * FROM farmers WHERE username = ?', [username], (err, results) => {
      if (err) {
        return callback(err);
      }
      callback(null, results[0]);
    });
  }
};

module.exports = Farmer;
