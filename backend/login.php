<?php

$_isvalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $mysqli = require __DIR__ . "/db.php";

    $email = isset($_POST["email"]) ? $mysqli->real_escape_string($_POST["email"]) : null;

    $sql = sprintf("SELECT * FROM customers_data WHERE email='%s'", $email);

    $result = $mysqli->query($sql);

    $user = $result->fetch_assoc();

    if ($user) {
        $hashedPassword = password_hash($_POST["password"], PASSWORD_DEFAULT);
        if (isset($_POST["password"]) && password_verify($hashedPassword, $user["password"])) {
            session_start();

            $_SESSION["email"] = $user["email"];
            header("Location: ../index.html");
            exit;
        }
    }
}
?>
