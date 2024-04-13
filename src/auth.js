const pool = require('./db');

// Verify user authentication
function verifyUser(username, password, callback) {
  const query = 'SELECT * FROM users WHERE username = ? AND password = ?';
  pool.query(query, [username, password], (err, results) => {
    if (err) {
      console.error('Error querying database:', err);
      callback(err, null);
      return;
    }
    if (results.length === 1) {
      callback(null, true); // User authenticated
    } else {
      callback(null, false); // User not authenticated
    }
  });
}

// Example usage
verifyUser('example_username', 'example_password', (err, authenticated) => {
  if (err) {
    console.error('Error verifying user authentication:', err);
    return;
  }
  if (authenticated) {
    console.log('User authenticated');
  } else {
    console.log('Invalid username or password');
  }
});
