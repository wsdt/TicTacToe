<?php
	include "dbNewConnection.php";

	$ordiestring = "<p><strong>PHP Info: </strong>Abfrage war nicht möglich.</p>";

	if(!empty($_POST))
    {
        $username = strtolower($_POST["username"]);
        $passwort = $_POST["passwort"];
        $passwort2 = $_POST["passwort2"];
        //$hash = hash('sha256', $passwort);
        $hash = password_hash($passwort,PASSWORD_BCRYPT);




        if ($passwort == $passwort2){
            if ($_POST["passwort"] == NULL){
                echo "Passwort ist leer";
            } else {
                $control = 0;
                $sql = "SELECT username FROM Users WHERE username = '$username'";
                $result = mysqli_query($tunnel, $sql) or die($ordiestring);
                while ($row = mysqli_fetch_object($result)) {
                    $control++;
                }
                if ($control != 0) {
                    echo "<p>Username <strong>$username</strong> existiert bereits! <a href='../../register.php'>zurück</a> </p>";
                } else {
                    echo "Speicherung in DB";
                    $sql = "INSERT INTO Users (username, passwort) VALUES ('" . $username . "', '" . $hash . "');";
                    echo "<p><strong>PHP Info: </strong>" . $sql . "</p>";
                    $result = mysqli_query($tunnel, $sql);
                    echo "<p>Benutzer wurde erfolgreich angelegt <a href='../../index.php'>Anmelden</a> </p>";
                }
            }
        } else {
            echo "Passwörter stimmen nicht überein";
            echo "Passwort 1: " . $passwort . " Passwort 2: " . $passwort2;
        }
        mysqli_close($tunnel);

    }


?>
