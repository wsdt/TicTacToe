<?php
	include "dbNewConnection.php";
	$results = mysqli_query($tunnel, "SELECT * FROM student;");
?>

<html>
	<head>
		<title>Data Engineering Advanced</title>
	</head>
	<body>
		<h1>Hello World!</h1>
		<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui. Etiam rhoncus.</p>
		
		<h2>Search Student by ID</h2>
		<form action="getStudentByID.php" type="submit" method="post">
			<input type="text" name="studentid"/>
			<input type="submit" name="submit" value="Hit me"/>
		</form>
		
		<h2>Insert new Student</h2>
		<form action="insertNewStudent.php" type="submit" method="post">
			<p>First name: <input type="text" name="firstname"/></p>
			<p>Last name: <input type="text" name="lastname"/></p>
			<p>Birth date: <input type="text" name="birthdate"/></p>
			<input type="submit" value="Save to DB" name="submit"/>
		</form>
		
		<h2>Search Student by ID with combo box</h2>
		<form method="post" type="submit" action="getStudentByID.php">
			<select name="studentid">
				<?php
					while($row = mysqli_fetch_array($results)){
						echo "<option value='" . $row["sid"] . "'>" . $row["fname"] . " " . $row["lname"] . "</option>";
					}
				?>
			</select>
			<input type="submit" name="action" value="Display"/>
			<input type="submit" name="action" value="Delete"/>
		</form>
		
	</body>
</html>