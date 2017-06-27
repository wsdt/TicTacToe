<?php
	require "dbNewConnection.php";
	require_once "../user.php";

	$ordiestring = "<p><strong>PHP Info: </strong>Abfrage war nicht möglich.</p>";


	//Eingabewerte werden an die Variablen übergeben, Passwort wird mit hash-Funktion verschlüsselt
	if(!empty($_POST))
    {
        $tmp_user = new User();
        /*$max->name = "Max Mustermann";
        $max->setEmail("max@muster.de");*/
        $isEverythingOk=true;

        if(!($tmp_user->setUsername($_POST["username"]))) {
            echo "ERROR: Username konnte nicht gespeichert werden! [in insertNewUser()]";
            $isEverythingOk = false;
        }

        if(!($tmp_user->setPassword($_POST["passwort"],$_POST["passwort2"]))) { //TODO: Funktioniert nicht immer
            echo "ERROR: Passwort entspricht nicht den Richtlinien (länger 3, nicht leer und muss mit Verify_Passwort übereinstimmen! [in insertNewUser()]";
            $isEverythingOk = false;
        }

        if ($isEverythingOk) {
            if($tmp_user->DB_addUser()) {//Füge User in die Datenbank ein. Highscore hat er noch keinen, da er noch nicht gespielt hat.
                echo "MELDUNG: Benutzer erfolgreich registriert. \nSie werden in 5 Sekunden weitergeleitet.";
            }
        }
        unset($tmp_user); //Lösche Referenz, so wird auch unser Destruktor aufgerufen.
    }

header( "refresh:5;url=../../index.php" ); //Zur Startseite weiterleiten

?>
