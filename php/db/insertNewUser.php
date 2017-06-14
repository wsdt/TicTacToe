<?php
	include "dbNewConnection.php";

	$username = $_GET["username"];
	$passwort = $_GET["passwort"];

	$sql = "INSERT INTO Users (username, passwort) VALUES ('" . $username . "', '" . $passwort . "');";

	echo "<p><strong>PHP Info: </strong>" . $sql . "</p>";

	$result = mysqli_query($tunnel, $sql);

	echo $result;
?>