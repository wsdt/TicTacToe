<?php

//Datenbankverbindung wird hergestellt
include "dbDetails.php";
$tunnel = "NoConnection";

	if (empty($_GET['debug'])) {
	    $tunnel = mysqli_connect($server, $user, $pwd, $db) or die("<p><strong>PHP Info: </strong>Verbindung konnte nicht hergestellt werden.</p>");
        if ($tunnel == "NoConnection") {
            echo "DB ERROR: DB Connection konnte nicht aufgebaut werden! [in dbNewConnection.php()]";
        }
	}
?>