<?php

if (empty($_POST["username"])) {
    die("Name is required");
}

if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    die("Valid email is required");
}

if (strlen($_POST["password"]) < 8) {
    die("Password must be at least 8 characters");
}

if (!preg_match("/[a-z]/i", $_POST["password"])) {
    die("Password must contain at least one letter");
}

if (!preg_match("/[0-9]/", $_POST["password"])) {
    die("Password must contain at least one number");
}

if ($_POST["password"] !== $_POST["re_password"]) {
    die("Passwords must match");
}
if (empty($_POST["mobile"])) {
    die("Number is required");
}

$mysqli = require __DIR__ . "/db.php";

// Hash the password
$hashedPassword = password_hash($_POST["password"], PASSWORD_DEFAULT);

$sql = "INSERT INTO customers_data (username, email, password, mobile)
        VALUES (?, ?, ?, ?)";
        
$stmt = $mysqli->stmt_init();

if (!$stmt->prepare($sql)) {
    die("SQL error: " . $mysqli->error);
}

$stmt->bind_param("ssss",
                  $_POST["username"],
                  $_POST["email"],
                  $hashedPassword, // Use hashed password
                  $_POST["mobile"]);
                  
if ($stmt->execute()) {

    header("Location: ../index.html");
    exit;
    
} else {
    
    if ($mysqli->errno === 1062) {
        die("email already taken");
    } else {
        die($mysqli->error . " " . $mysqli->errno);
    }
}
?>
