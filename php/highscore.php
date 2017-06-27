<?php

/*class Highscore
{*/

    function calcReputation($wins,$losses)
    { //Setter and Calculator of Reputation
        // WINS = 1 Punkte wert ; LOSSES = -1 Punkte wert ; DRAWS = 0 Punkt wert
        if (!isset($wins) || !isset($losses) || ($wins == 0 && $losses == 0)) { //wenn beide 0 sind auch, da sonst DIV/0
            //$this->reputation = "ERROR";
            return 0;
        } else {
            $all_games = $wins + $losses;
            $rep = ($wins - $losses) / $all_games;
            if ($rep > 1) {
                $rep = 1;
            } else if ($rep < -1) {
                $rep = -1;
            } //Wenn komische Rep-Werte, hier evtl. Fehlerquelle
            return $rep;
        }
    }


//DB-Operationen
    function DB_refreshOrAddToHighscore()
    {
        //TODO
    }

    function hasUserEverPlayed($username)
    {
        require "db/dbNewConnection.php"; //Nicht require_once da sonst evtl. nur einmal für diese Datei aufgerufen

        $control = 0;
        $sql = "SELECT username FROM Highscore WHERE username = '" . $username . "'";
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
/*function setHighscoreRow($user_object) {
        $this->highscore_row = $user_object;
}

function getHighscoreRow() {
        return $this->highscore_row;
}*/

   /* function loadRow_from_DB($username) // = BENUTZERPROFIL aus Datenbank laden
    {
        require 'db/dbNewConnection.php';
        $sql = "SELECT * FROM Highscore WHERE Username = '".$username."';";
        $user = mysqli_query($tunnel, $sql);
        if (empty($user)) {
            $this->closeDBConnection($tunnel);
            return false; //Say that user was not found
        } else {
            $tmp_user = new Highscore();

            while ($tmp = mysqli_fetch_array($user)) {
                $tmp_user->setUsername($tmp['Username']);
                $tmp_user->setPasswordHash($tmp['Passwort']);
            }
            $this->closeDBConnection($tunnel);
            return $tmp_user; //Gib User zurück für den übergebener Username passt, wenn keiner existiert wird false zurückgegeben
        }
    }*/


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

    function saveHighscoreEntry() {
        {
            //TODO: Hidden Form Field with all rounds results OR AJAX
            //erst aufrufen über formular
            //Mit SQL Statement INSERT INTO (gleich wie eine Abfrage)

            require "db/dbNewConnection.php";
            //Spiel in die Highscore-Liste einfügen
            if (isset($_POST['username']) && isset($_POST['score']) && isset($_POST['score'])) {

                $username = strip_tags(mysqli_real_escape_string($tunnel, $_POST['username']));
                $wins = strip_tags(mysqli_real_escape_string($tunnel, $_POST['wins']));
                $draws = strip_tags(mysqli_real_escape_string($tunnel, $_POST['draws']));
                $losses = strip_tags(mysqli_real_escape_string($tunnel, $_POST['losses']));
                $sql = mysqli_query($tunnel, "INSERT INTO highscore (`Username`,`Wins`, `Draws`, `Losses`) VALUES (" . $username . "','" . $wins . "', '" . $draws . "', '" . $losses . "');");

                if ($sql) {
                    echo '<script type="text/javascript">show_notification("#0000ff","Ihr Highscore wurde in unsere Datenbank übertragen!");</script>';
                } else {
                    echo 'There was a problem saving your score. Please try again later.' . mysqli_error($tunnel);;
                }
            } else {
                echo 'Your name or score wasnt passed in the request.';
            }
        }
    }

    function deleteHighscoreEntry($username)
    { //TODO: Testing
        require "db/dbNewConnection.php";
        //Spiel in die Highscore-Liste einfügen
        if (empty($username)) {

            $username = strip_tags(mysqli_real_escape_string($tunnel, $username));
            $sql = mysqli_query($tunnel, "DELETE FROM highscore WHERE Username = '".$username."'");

            if ($sql) {
                echo 'Your score was deleted. Congrats!';
            } else {
                echo 'There was a problem deleting your score. Please try again later.' . mysqli_error($tunnel);;
            }
        } else {
            echo 'Your name or score wasnt passed in the request.';
        }
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

            $sql = "SELECT *,Wins/(Wins+Losses+Draws)*100 AS Ranking FROM Highscore ORDER BY Ranking"; //ORDER BY Platzierung ASC, (Platzierung rausgenommen), da sonst bei neuem Eintrag evtl. alle Einträge neu reinzuspeichern
            $result = mysqli_query($tunnel, $sql) or die($ordiestring); //Tunnel unterstrichen, da bei debug nicht definiert.

            if (mysqli_num_rows($result) == 0) {
                echo "Keine Einträge vorhanden!";
            } else {
                //usort($result, repCompare(calcReputation($result['Wins'], $result['Losses']), calcReputation($result['Wins'], $result['Losses']))); //nicht mit $row[''] weil ja für jedes Element zu vergleichen
                $n = 0; //Ranking
                while($row = mysqli_fetch_array($result)) {
                    //Declare variables
                    //$row = json_decode($row,true);
                    //$platzierung = $row->Platzierung;
                    $username = $row['Username']; //$row->Username; Wenn mysqli_fetch_object dann so
                    $wins = $row['Wins'];
                    $draws = $row['Draws'];
                    $losses = $row['Losses'];
                    $reputation = $row['Ranking'];

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


//}
?>