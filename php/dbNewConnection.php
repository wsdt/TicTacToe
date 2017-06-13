<?php
	include "dbDetails.php";

	$tunnel = mysqli_connect($server, $user, $pwd, $db) or die("<p><strong>PHP Info: </strong>Verbindung konnte nicht hergestellt werden.</p>");

?>