<?php
	include "dbNewConnection.php";

	$ordiestring = "<p><strong>PHP Info: </strong>Abfrage war nicht möglich.</p>";


	//Eingabewerte werden an die Variablen übergeben, Passwort wird mit hash-Funktion verschlüsselt
	if(!empty($_POST))
    {
        $tmp_user = new User();
        /*$max->name = "Max Mustermann";
        $max->setEmail("max@muster.de");*/

        if(!($tmp_user->setUsername($_POST["username"]))) {
            echo "ERROR: Username konnte nicht gespeichert werden! (PHP-Class-Error)";
        }

        if(!($tmp_user->setPassword($_POST["passwort"],$_POST["passwort2"]))) {
            echo "ERROR: Password konnte nicht gespeichert werden! (PHP-Class-Error)";
        }

        $tmp_user->DB_addUser(); //Füge User in die Datenbank ein. Highscore hat er noch keinen, da er noch nicht gespielt hat.
        unset($tmp_user); //Lösche Referenz, so wird auch unser Destruktor aufgerufen.
    }

?>
