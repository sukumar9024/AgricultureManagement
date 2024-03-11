// controllers/farmerController.js

// Import necessary modules
const mysqlConnection = require('../config/mysqlConnection');

// Controller logic for managing farmers
const farmerController = {
  // Get all farmers
  getAllFarmers: (req, res) => {
    mysqlConnection.query('SELECT * FROM farmers_data', (error, results) => {
      if (error) {
        console.error('Error retrieving farmers:', error);
        res.status(500).json({ error: 'Internal server error' });
      } else {
        res.json(results);
      }
    });
  },

  // Get farmer by ID
  getFarmerById: (req, res) => {
    const { id } = req.params;
    mysqlConnection.query('SELECT * FROM farmers_data WHERE id = ?', [id], (error, results) => {
      if (error) {
        console.error('Error retrieving farmer:', error);
        res.status(500).json({ error: 'Internal server error' });
      } else if (results.length === 0) {
        res.status(404).json({ error: 'Farmer not found' });
      } else {
        res.json(results[0]);
      }
    });
  },

  // Create a new farmer
  createFarmer: (req, res) => {
    const { username, password } = req.body;
    mysqlConnection.query('INSERT INTO farmers_data (username, password) VALUES (?, ?)', [username, password], (error, results) => {
      if (error) {
        console.error('Error creating farmer:', error);
        res.status(500).json({ error: 'Internal server error' });
      } else {
        res.status(201).json({ message: 'Farmer created successfully' });
      }
    });
  },

  // Update a farmer by ID
  updateFarmerById: (req, res) => {
    const { id } = req.params;
    const { username, password } = req.body;
    mysqlConnection.query('UPDATE farmers_data SET username = ?, password = ? WHERE id = ?', [username, password, id], (error, results) => {
      if (error) {
        console.error('Error updating farmer:', error);
        res.status(500).json({ error: 'Internal server error' });
      } else if (results.affectedRows === 0) {
        res.status(404).json({ error: 'Farmer not found' });
      } else {
        res.json({ message: 'Farmer updated successfully' });
      }
    });
  },

  // Delete a farmer by ID
  deleteFarmerById: (req, res) => {
    const { id } = req.params;
    mysqlConnection.query('DELETE FROM farmers_data WHERE id = ?', [id], (error, results) => {
      if (error) {
        console.error('Error deleting farmer:', error);
        res.status(500).json({ error: 'Internal server error' });
      } else if (results.affectedRows === 0) {
        res.status(404).json({ error: 'Farmer not found' });
      } else {
        res.json({ message: 'Farmer deleted successfully' });
      }
    });
  }
};

module.exports = farmerController;
