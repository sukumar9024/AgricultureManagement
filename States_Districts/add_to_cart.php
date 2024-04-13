<?php
session_start();

// Check if the user is logged in
if(!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] !== true) {
    // User is not logged in, redirect to login page
    header("Location: ../login.html");
    exit;
}

// Check if username is set in session
if(isset($_SESSION["username"])) {
    $username_product = $_SESSION["username"];
} else {
    // If username is not set, redirect to login page
    header("Location: ../login.html");
    exit;
}

// Check if product ID is received
if(isset($_POST['productId'])) {
    // Get the product ID from the request
    $productId = $_POST['productId'];

    // Insert the product into the cart table
    $servername = "localhost"; // Change this if your database is hosted elsewhere
    $username = "root";
    $password = "";
    $dbname = "agriculture_management";
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and execute the SQL query to insert the product into the cart table
    $sql = "INSERT INTO cart (product_id, username) VALUES ('$productId', '$username_product')";
    if ($conn->query($sql) === TRUE) {
        // Insertion successful
        echo "Product added to cart successfully.";
    } else {
        // Insertion failed
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the database connection
    $conn->close();
} else {
    // If product ID is not received, send an error message
    echo "Error: Product ID not received.";
}
?>
