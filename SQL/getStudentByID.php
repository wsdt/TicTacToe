<?php
	include "dbNewConnection.php";
	
	$sid = $_POST["studentid"];
	$action = $_POST["action"];
	$ordiestring = "<p><strong>PHP Info: </strong>Abfrage war nicht möglich.</p>";
	
	if ($action=="Display"){
		$sql = "SELECT * FROM student WHERE sid = " . $sid . ";";	
		$result = mysqli_query($tunnel, $sql) or die($ordiestring);
		while($row = mysqli_fetch_array($result)){
			
			echo "
			<form action='updatestudent.php' type='submit' method='post'>
				<p>ID <input type='text' name='sid' value='" . $sid . "'/></p>
				<p>Vorname <input type='text' name='fname' value='" . $row["fname"] . "'/></p>
				<p>Nachname <input type='text' name='lname' value='" . $row["lname"] . "'/></p>
				<p>Geburtsdatum <input type='text' name='bdate' value='" . $row["bdate"] . "'/></p>
				<input type='submit' name='action' value='Update Student'/>
			</form>";
		}
	} else if ($action=="Delete"){
		$sql = "DELETE FROM student WHERE sid = " . $sid . ";";
		$result = mysqli_query($tunnel, $sql) or die($ordiestring);
		if ($result == 1) {
			echo "Student mit ID " . $sid . " wurde gelöscht.";
		} else {
			echo "Fehler.";
		}
	}

	$resp = mysqli_close($tunnel);

?>