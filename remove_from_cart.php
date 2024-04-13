<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.php'); // Redirect to the login page if not logged in
    exit;
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "agriculture_management";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get the product ID from the request
$product_id = $_GET['product_id'];

// Retrieve username from session
$username = $_SESSION['username'];

// Query to remove the item from the cart for the current user
$remove_query = "DELETE FROM cart WHERE username = '$username' AND product_id = $product_id";

if (mysqli_query($conn, $remove_query)) {
    echo "Item removed successfully";
} else {
    echo "Error removing item: " . mysqli_error($conn);
}

// Close connection
mysqli_close($conn);
?>
