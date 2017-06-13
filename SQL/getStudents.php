<?php
	include "dbNewConnection.php";

	$result = mysqli_query($tunnel, "SELECT * FROM student") or die("<p><strong>PHP Info: </strong>Abfrage war nicht möglich.</p>");
	
	//echo "<p><strong>PHP Info: </strong>Abfrage war erfolgreich.</p>";
	
	echo "<ul>";
	
	while($row = mysqli_fetch_array($result)){
		echo "<li>" . $row["fname"] . " " . $row["lname"] . "</li>";		
	}
	
	echo "</ul>";
?>