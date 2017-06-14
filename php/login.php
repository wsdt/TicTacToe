<?php

include("db/dbNewConnection.php");
session_start();

$message="";
if(!empty($_GET["login"])) {
    $result = mysqli_query($tunnel,"SELECT * FROM Users WHERE username='" . $_GET["username"] . "' and passwort = '". $_GET["passwort"]."'");
    $row  = mysqli_fetch_array($result);
    if(is_array($row)) {
        $_SESSION["username"] = $row['username'];
        echo "perfekt";
    } else {
        $message = "Invalid Username or Password!";
    }
}
?>