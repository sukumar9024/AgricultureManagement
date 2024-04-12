<?php

$_isvalid = False;

if ($_SERVER["REQUEST METHOD"] === "POST" ){
    $mysqli = require __DIR__ . "/db.php";

    $email = isset($_POST["email"]) ? $mysqli->real_escape_string($_POST["email"]): null;
}

$sql = sprintf("SELECT * FROM users WHERE email='%s'",$email);

$result = $mtsqli->query($sql);

$user = $result->fetch_asso();
if($user){
    if (isset($_POST["password"]) && $_POST["password"] === $user["password"]){
        session_start();

        $_SESSION["email"] = $_user["email"];
        header("Location:index.html");
        exit;
    }
}
?>