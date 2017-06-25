<?php
//Philipp's test file: presumably unused


session_start();
if (isset($_SESSION['username']))
{
    unset($_SESSION['username']);
}
header("location:index.php");

?>