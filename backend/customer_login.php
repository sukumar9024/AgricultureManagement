<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Include your database connection file
    require_once __DIR__ . "/db.php";

    // Retrieve and sanitize user inputs
    $email = isset($_POST["email"]) ? $mysqli->real_escape_string($_POST["email"]) : null;
    $password = isset($_POST["password"]) ? $_POST["password"] : null;

    // Fetch user data from the database
    $sql = "SELECT * FROM customers_data WHERE email='$email'";
    $result = $mysqli->query($sql);

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify the hashed password
        if (password_verify($password, $user["password"])) {
            // Password is correct, set session variables and redirect
            $_SESSION["email"] = $user["email"];
            header("Location:../States_Districts/dynamically_changing_cities_JS.php");
            exit;
        } else {
            // Password is incorrect
            echo "Invalid email or password.";
        }
    } else {
        // User not found
        echo "User not found.";
    }
} else {
    // Redirect back to login page if accessed directly
    header("Location: ../login.html");
    exit;
}
?>
