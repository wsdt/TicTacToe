<?php
	$lname = $_POST["lname"];
	$fname = $_POST["fname"];
	$bdate = $_POST["bdate"];
	$sid = $_POST["sid"];
	
	$sql = "UPDATE student SET lname = '" . $lname . "', fname = '" . $fname . "', bdate = '" . $bdate . "' WHERE sid = " . $sid . ";";
	
	include "dbNewConnection.php";
	$result = mysqli_query($tunnel, $sql);
	
	if($result == 1){
		echo "Student mit ID " . $sid . " erfolgreich aktualisiert.";
	}
	
?>