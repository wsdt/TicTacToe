<?php

class User
{
//Definition der Eigenschaften name, email und password
    private $username;
    private $wins, $draws, $losses;
    private $password;
    private $reputation;

    //Konstruktor
    function __construct1($username, $wins, $draws, $losses, $password, $password_verify, $saveToDatabase) //Wenn saveToDatabase = true, dann wird DB_addUser() ausgeführt
    {
        if (!(
            $this->setUsername($username) ||
            $this->setWinsDrawsLosses($wins, $draws, $losses) ||
            $this->setPassword($password, $password_verify) || //Wurde Passwort angenommen?
            $this->calcReputation())
        ) {
            $this->__destruct();
            echo "ERROR: User konnte nicht erstellt werden! (User.php, Class Error)";
            return false;
        } else {
            if ($saveToDatabase) {
                $this->DB_addUser(); //Adde User in der Datenbank
            }
            return true;
        }
    }

    //Konstruktor
    function __construct2($username, $wins, $draws, $losses, $hash, $saveToDatabase)
    {
        if (!(
            $this->setUsername($username) ||
            $this->setWinsDrawsLosses($wins, $draws, $losses) ||
            $this->setPasswordHash($hash) || //Wurde Passwort angenommen?
            $this->calcReputation())
        ) {
            $this->__destruct();
            echo "ERROR: User konnte nicht erstellt werden! (User.php, Class Error)";
            return false;
        } else {
            if ($saveToDatabase) {
                $this->DB_addUser();
            }
            return true;
        }
    }

    function __destruct()
    { //Delete User in PHP-Code
        $this->username = null;
        $this->password = null;
        $this->losses = null;
        $this->draws = null;
        $this->wins = null;
        $this->reputation = null;
        //$this->DB_deleteUser(); //Lösche User aus Datenbank
    }

//DB-Operationen
    function loadUser_from_DB($username) // = BENUTZERPROFIL aus Datenbank laden
    {
        require 'db/dbNewConnection.php';
        $sql = "SELECT * FROM Users WHERE Username = '".$username."';";
        $user = mysqli_query($tunnel, $sql);
        if (empty($user) || $user == null) {
            $this->closeDBConnection($tunnel);
            return false; //Say that user was not found
        } else {
            $tmp_user = new User();

            while ($tmp = mysqli_fetch_array($user)) {
                $tmp_user->setUsername($tmp['Username']);
                $tmp_user->setPasswordHash($tmp['Passwort']);
            }
            $this->closeDBConnection($tunnel);
            return $tmp_user; //Gib User zurück für den übergebener Username passt, wenn keiner existiert wird false zurückgegeben
        }
    }

    function DB_addUser()
    {
        if ($this->isUsernameAvailable()) {
            require 'db/dbNewConnection.php';
            $sql = "INSERT INTO Users (username, passwort) VALUES ('" . $this->getUsername() . "', '" . $this->getPasswordHash() . "');";
            $result = mysqli_query($tunnel, $sql);

            $this->closeDBConnection($tunnel);

            if (!$result) {
                echo "DB ERROR: User konnte nicht in die Datenbank übertragen werden! [in DB_addUser()]";
                return false;
            } else {
                return true;
            }
        } else {
            echo "DB ERROR: Username bereits vorhanden! Bitte wählen Sie einen anderen!";
        }
    }

    function DB_deleteUser()
    {
        require 'db/dbNewConnection.php';
        $sql_hc = "DELETE FROM Highscore WHERE username='".$this->getUsername()."';'";
        $sql_us = "DELETE FROM Users WHERE username='".$this->getUsername()."';";
        $result = mysqli_query($tunnel, $sql_hc);
        $result2 = mysqli_query($tunnel, $sql_us);
        if (!$result || !$result2) {
            echo "DB ERROR: User konnte in der Datenbank nicht gelöscht werden! [in DB_deleteUser()]";
        }

        $this->closeDBConnection($tunnel);
    }

    function DB_refreshOrAddToHighscore()
    {
        //TODO
    }

    function isUsernameAvailable()
    {
        require "db/dbNewConnection.php"; //Nicht require_once da sonst evtl. nur einmal für diese Datei aufgerufen

        $control = 0;
        $sql = "SELECT username FROM Users WHERE username = '" . $this->username . "'";
        $result = mysqli_query($tunnel, $sql) or die("DB ERROR: Verbindung konnte nicht hergestellt werden! [in isUsernameAvailable()]");
        while ($row = mysqli_fetch_object($result)) {
            $control++;
        }

        $this->closeDBConnection($tunnel); //Schließe Datenbankverbindung

        //Username wird überprüft, ob bereits vorhanden, dann wird true zurückgegeben wenn keiner vorhanden war
        if ($control != 0) {
            return false;
        } else {
            return true;
        }

    }

    function closeDBConnection($tunnel) //Tunnel = DB Verbindung/Instanz übergeben
    {
        if (!mysqli_close($tunnel)) {
            echo "FATAL_ERROR: Datenbank-Verbindung konnte nicht geschlossen werden. [in isUsernameAvailable()]";
        }
    }

//Getter/Setter definieren
    function setUsername($username)
    {
        require 'db/dbNewConnection.php';
        if (empty($username) || $username == null || strlen($username) < 4) {
            $this->closeDBConnection($tunnel);
            return false;
        } else {
            $this->username = mysqli_real_escape_string($tunnel, $username);
            $this->closeDBConnection($tunnel);
            return true;
        }
    }

    function getUsername()
    {
        return $this->username;
    }

    function setWinsDrawsLosses($wins, $draws, $losses)
    { //Sollen nicht einzeln befüllt werden können
        if (empty($wins) || empty($draws) || empty($losses) || $wins == null || $draws == null || $losses == null) { //empty = "" aber nicht null
            return false;
        } else {
            $this->wins = $wins;
            $this->draws = $draws;
            $this->losses = $losses;
            return true;
        }
    }

    function getWins()
    {
        return $this->wins;
    }

    function getDraws()
    {
        return $this->draws;
    }

    function getLosses()
    {
        return $this->losses;
    }

    function setPasswordHash($hash)
    {
        //Setze Passwort unverschlüsselt, da schon verschlüsselt in DB gespeichert wurde
        if (empty($hash) || $hash == null) {
            //Achtung, diese Funktion darf nur genutzt werden, wenn der übergebene Wert ein Hash ist!
            return false;
        } else {
            $this->password = $hash;
            return true;
        }
    }

    function setPassword($password, $password_verify)
    { //Passwort-Setzung nur mit Kontrolleingabe möglich
        //Verschlüssle Passwort
        if (empty($password) || empty($password_verify) || $password === null || $password_verify === null || strcmp($password, $password_verify) != 0 //0 kommt raus, wenn beide Strings gleich
            || $password < 4) {
            //nur $password auf Länge zu prüfen, da er bei Ungleichheit ohnehin hier reinspringt
            //Wenn ein Passwort leer, den Sicherheitsbestimmungen nicht entspricht oder beide Passwörter ungleich sind gib false zurück.
            //Hier keinen Dummy-Wert setzen, da sonst im Fehlerfall das Passwort überschrieben wird.
            return false;
        } else {
            require 'db/dbNewConnection.php';
            $this->password = password_hash(mysqli_real_escape_string($tunnel, $password), PASSWORD_BCRYPT);
            $this->closeDBConnection($tunnel);
            return true;
        }
    }

    function getPasswordHash()
    {
        //Übergib verschlüsseltes Passwort
        return $this->password;
    }

    function isPasswordValid($password_for_check)
    {
        //Prüfe ob Passwort ok
        return password_verify($password_for_check, $this->getPasswordHash());
    }

//Berechne Reputation/Ansehen (daraus wird die Rangfolge (=Ranking) bestimmt)
    function calcReputation()
    { //Setter and Calculator of Reputation
        // WINS = 1 Punkte wert ; LOSSES = -1 Punkte wert ; DRAWS = 0 Punkt wert
        if (!isset($this->wins) || !isset($this->losses) || ($this->wins == 0 && $this->losses == 0)) { //wenn beide 0 sind auch, da sonst DIV/0
            //$this->reputation = "ERROR";
            return false;
        } else {
            $all_games = $this->wins + $this->losses;
            $rep = ($this->wins - $this->losses) / $all_games;
            if ($rep > 1) {
                $rep = 1;
            } else if ($rep < -1) {
                $rep = -1;
            } //Wenn komische Rep-Werte, hier evtl. Fehlerquelle
            $this->reputation = $rep;
            return true;
        }
    }

    function getReputation()
    {
        return $this->reputation;
    }


//Vergleiche welche Reputation größer/kleiner ist als die Andere (Wichtig für Sortierung bei der Highscore Ausgabe)
    function repCompare($a, $b)
    { //Prüfe ob $a eine höhere Reputation (gib >0 zurück) oder eine kleinere hat als $b (gib <0 zurück)
        if ($a >= $b) {
            return 1;
        } else if ($a < $b) {
            return -1;
        } else {
            return "ERROR"; //Durch String wird Fehler erzeugt. Deshalb muss oben auch >= stehen, damit alle Fälle abgedeckt
        }
    }


}
?>