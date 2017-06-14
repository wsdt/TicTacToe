<?php
	include "dbNewConnection.php";
	$fname = $_POST["firstname"];
	$lname = $_POST["lastname"];
	$bdate = $_POST["birthdate"];
	
	$sql = "INSERT INTO student (fname, lname, bdate) VALUES ('" . $fname . "', '" . $lname . "', '" . $bdate ."');";
	
	echo "<p><strong>PHP Info: </strong>" . $sql . "</p>";
	
	$result = mysqli_query($tunnel, $sql);
	
	echo $result;
?>