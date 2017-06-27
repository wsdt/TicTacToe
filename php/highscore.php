<?php

class Highscore
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
    function DB_refreshOrAddToHighscore()
    {
        //TODO
    }

    function hasUserEverPlayed()
    {
        require "db/dbNewConnection.php"; //Nicht require_once da sonst evtl. nur einmal für diese Datei aufgerufen

        $control = 0;
        $sql = "SELECT username FROM Highscore WHERE username = '" . $this->username . "'";
        $result = mysqli_query($tunnel, $sql) or die("DB ERROR: Verbindung konnte nicht hergestellt werden! [in isUsernameAvailable()]");
        while ($row = mysqli_fetch_object($result)) {
            $control++;
        }

        $this->closeDBConnection($tunnel); //Schließe Datenbankverbindung

        //Username wird überprüft, ob bereits vorhanden, dann wird true zurückgegeben wenn keiner vorhanden war
        if ($control != 0) {
            return true;
        } else {
            return false; //Gibt false zurück, wenn User noch keinen Highscore-Eintrag hat.
        }

    }

    function closeDBConnection($tunnel) //Tunnel = DB Verbindung/Instanz übergeben
    {
        if (!mysqli_close($tunnel)) {
            echo "FATAL_ERROR: Datenbank-Verbindung konnte nicht geschlossen werden. [in isUsernameAvailable()]";
        }
    }

//Getter/Setter definieren


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

    function saveHighscoreEntry()
    {
        //TODO: Hidden Form Field with all rounds results OR AJAX
        //erst aufrufen über formular
        //Mit SQL Statement INSERT INTO (gleich wie eine Abfrage)

        require "db/dbNewConnection.php";
        //Spiel in die Highscore-Liste einfügen
        if (isset($_GET['username']) && isset($_GET['score']) && isset($_GET['score'])) {

            $username = strip_tags(mysqli_real_escape_string($tunnel, $_GET['username']));
            $wins = strip_tags(mysqli_real_escape_string($tunnel, $_GET['wins']));
            $draws = strip_tags(mysqli_real_escape_string($tunnel, $_GET['draws']));
            $losses = strip_tags(mysqli_real_escape_string($tunnel, $_GET['losses']));
            $sql = mysqli_query($tunnel, "INSERT INTO highscore (`platzierung`,`username`,`wins`, `draws`, `losses`, `ratio`) VALUES ('','$username','$wins', '$draws', '$losses');");

            if ($sql) {
                echo 'Your score was saved. Congrats!';
            } else {
                echo 'There was a problem saving your score. Please try again later.' . mysqli_error($tunnel);;
            }
        } else {
            echo 'Your name or score wasnt passed in the request.';
        }


    }

    function deleteHighscoreEntry()
    {
        //TODO
    }


    function generateHighscoreTable()
    {
        //require_once 'db/SQL2PHP.php'; //declare variables

        //Generate headings
        echo "<div class=\"highscore_table_row_caption\">
                <div class=\"highscore_table_cell highscore_table_caption\">Ranking</div>
                <div class=\"highscore_table_cell highscore_table_caption\">Username</div>
                <div class=\"highscore_table_cell highscore_table_caption\">Wins</div>
                <div class=\"highscore_table_cell highscore_table_caption\">Draws</div>
                <div class=\"highscore_table_cell highscore_table_caption\">Losses</div>
                <div class=\"highscore_table_cell highscore_table_caption\">Reputation <!-- Reputation = Win/Loss Ratio --></div>
            </div>";

        require "db/dbNewConnection.php";

        if (isset($tunnel)) {
            $ordiestring = "<p><strong>PHP Info: </strong>Abfrage war nicht möglich.</p>";

            $sql = "SELECT * FROM Highscore"; //ORDER BY Platzierung ASC, (Platzierung rausgenommen), da sonst bei neuem Eintrag evtl. alle Einträge neu reinzuspeichern
            $result = mysqli_query($tunnel, $sql) or die($ordiestring); //Tunnel unterstrichen, da bei debug nicht definiert.

            $result = mysqli_fetch_array($result);
            usort($result, $this->repCompare(calcReputation($result['Wins'], $result['Losses']), calcReputation($result['Wins'], $result['Losses']))); //nicht mit $row[''] weil ja für jedes Element zu vergleichen

            $n = 0; //Ranking
            foreach ($result as $row) {
                //Declare variables
                //$row = json_decode($row,true);
                //$platzierung = $row->Platzierung;
                $username = $row['Username']; //$row->Username; Wenn mysqli_fetch_object dann so
                $wins = $row['Wins'];
                $draws = $row['Draws'];
                $losses = $row['Losses'];
                $reputation = calcReputation($wins, $losses);

                //IMPORTANT: Sort user list after Reputation BEFORE ECHO in FOR!! (NICHT NOTWENDIG, da PLATZIERUNG IN DATENBANK GESPEICHERT!)
                echo "<div class=\"highscore_table_row\">
                <div class=\"highscore_table_cell\">" . (++$n) . "</div>
                <div class=\"highscore_table_cell\">" . $username . "</div>
                <div class=\"highscore_table_cell\">" . $wins . "</div>
                <div class=\"highscore_table_cell\">" . $draws . "</div>
                <div class=\"highscore_table_cell\">" . $losses . "</div>
                <div class=\"highscore_table_cell\">" . $reputation . "%</div>
            </div>"; //$platzierung (alt statt $n)
                //Datenbanktabelle Highscore muss in Datenbank nicht sortiert sein!! (ORDER BY Platzierung bei Ausgabe möglich)
            }
            mysqli_close($tunnel);
        } else {
            echo "<div class='highscore_table_row'>";
            for ($i = 0; $i < 5; $i++) {
                echo "<div class='highscore_table_db_err'><marquee>No DB Connection</marquee></div>";
            }
            echo "</div>";
        }
    }


}
?>