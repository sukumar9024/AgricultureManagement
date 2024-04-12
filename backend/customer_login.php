<?php

$_isvalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $mysqli = require __DIR__ . "/db.php";

    $email = isset($_POST["email"]) ? $mysqli->real_escape_string($_POST["email"]) : null;

    $sql = sprintf("SELECT * FROM customers_data WHERE email='%s'", $email);

    $result = $mysqli->query($sql);

    $user = $result->fetch_assoc();
    if ($user) {
        if (isset($_POST["password"])) {
            // Hash the submitted password
            $hashedPassword = password_hash($_POST["password"], PASSWORD_DEFAULT);

            // Compare hashed password
            if (password_verify($_POST['password'], $hashed_password)) {
                // Start session and set email
                session_start();
                $_SESSION["email"] = $user["email"];
                header("Location: ../index.html");
                exit;
            } else {
                // Incorrect password
                die("Incorrect password");
            }
        }
    }
}
?>
