<?php

/*class Highscore
{*/
require_once 'user.php';

//DB-Operationen
function DB_hasUserEverPlayed($username)
{
    require "db/dbNewConnection.php"; //Nicht require_once da sonst evtl. nur einmal für diese Datei aufgerufen

    $control = 0;
    $sql = "SELECT username FROM Highscore WHERE username = '" . $username . "'";
    $result = mysqli_query($tunnel, $sql) or die("DB ERROR: Verbindung konnte nicht hergestellt werden! [in isUsernameAvailable()]");
    while ($row = mysqli_fetch_object($result)) {
        $control++;
    }

    closeDBConnection($tunnel); //Schließe Datenbankverbindung, nutze statische Funktion

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

function DB_getHighscoreRow($username) { //Corresponding method for user entity in user.php named as loadUser_from_DB($username)
    //IMPORTANT: Nur aufrufen, wenn DB_hasUserEverplayer() = true

    require "db/dbNewConnection.php"; //Nicht require_once da sonst evtl. nur einmal für diese Datei aufgerufen

    $sql = "SELECT * FROM Highscore WHERE username = '" . $username . "'";
    $result = mysqli_query($tunnel, $sql) or die("DB ERROR: Verbindung konnte nicht hergestellt werden! [in isUsernameAvailable()]");

    $tmp_user = new User();
    while ($row = mysqli_fetch_array($result)) {
        $tmp_user->setUsername($row['Username']);
        $tmp_user->setWinsDrawsLosses($row['Wins'],$row['Draws'], $row['Losses']);
        closeDBConnection($tunnel); //Schließe Datenbankverbindung
        return $tmp_user; //Gib erstes(!) User-Objekt zurück, da Username=Primärschlüssel, dürfte ohnehin nur eine Row zurückkommen
    }
    $tmp_user->setWinsDrawsLosses("ERROR","ERROR", "ERROR"); //Löse Exception aus, wenn kein Element gefunden wurde
    return $tmp_user;
}


function DB_saveHighscoreEntry($username,$wins, $draws, $losses)
{
    //Hidden Form Field with all rounds results OR AJAX
    //erst aufrufen über formular
    //Mit SQL Statement INSERT INTO (gleich wie eine Abfrage)

    require "db/dbNewConnection.php";
    //Spiel in die Highscore-Liste einfügen
    if (!empty($username) && is_numeric($wins) && is_numeric($draws) && is_numeric($losses)) { //Use isset for wins/draws/losses instead of empty, because value can be 0!
        $username = strip_tags(mysqli_real_escape_string($tunnel, $username));
        $wins = intval(strip_tags(mysqli_real_escape_string($tunnel, $wins)));
        $draws = intval(strip_tags(mysqli_real_escape_string($tunnel, $draws)));
        $losses = intval(strip_tags(mysqli_real_escape_string($tunnel, $losses)));
        $score_setter = true; //Gehe davon aus, dass Score-Setter funktioniert


        //Insert if Username noch nicht vorhanden, ansonsten adde Wins, Draws etc. zu bestehenden Werten!
        if(DB_hasUserEverPlayed($username)) { //Update Row, when User has already an Highscore-Entry
            //Get User from Database
            $active_user = DB_getHighscoreRow($username); //Gibt User-Objekt zurück und speichert diesen
            
            //Wins etc. mit alten Werten addieren, auftoppen
            $score_setter = $active_user->setWinsDrawsLosses(($active_user->getWins() + $wins), ($active_user->getDraws() + $draws), ($active_user->getLosses() + $losses));

            //Wins, draws, losses does not need '' in sql, because it is INT, trotzdem mit '' falls wie komischerweise vorgekommen null Werte drin und MySQL ohnehin automatisch einen String zu Int castet wenn der Datentyp ein Integer ist
            $sql = mysqli_query($tunnel, "UPDATE Highscore SET Wins = '".$active_user->getWins()."', Draws = '".$active_user->getDraws()."', Losses = '".$active_user->getLosses()."' WHERE Username = '".$username."';");
        } else { //Insert new Row, when User never played before.
            $sql = mysqli_query($tunnel, "INSERT INTO highscore (Username,Wins, Draws, Losses) VALUES ('" . $username . "','" . $wins . "', '" . $draws . "', '" . $losses . "');");
        }

        if ($sql && $score_setter) {
            echo "SUCCESS: Ihr Highscore wurde in unsere Datenbank übertragen!"; //SUCCESS = Schlüsselwort in Ajax, damit später eine JS-Notification bei Success angezeigt wird.
        } else {
            echo "UPDATE Highscore SET Wins = '".$active_user->getWins()."', Draws = '".$active_user->getDraws()."', Losses = '".$active_user->getLosses()."' WHERE Username = '".$username."';";
            echo 'FAIL: There was a problem saving your score. Please try again later. Maybe User has already an entry. This message should not be shown. ' . mysqli_error($tunnel);;
        }
    } else {
        echo 'FAIL: Your name wasnt passed in the request.';
    }
}

function DB_deleteHighscoreEntry($username)
{ //works (tested)
    require "db/dbNewConnection.php";
    //Spiel in die Highscore-Liste einfügen
    if (empty($username)) {

        $username = strip_tags(mysqli_real_escape_string($tunnel, $username));
        $sql = mysqli_query($tunnel, "DELETE FROM highscore WHERE Username = '" . $username . "'");

        if ($sql) {
            echo 'Your score was deleted. Congrats!';
        } else {
            echo 'There was a problem deleting your score. Please try again later.' . mysqli_error($tunnel);;
        }
    } else {
        echo 'Your name was not passed in the request.';
    }
}


function DB_generateHighscoreTable()
{
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

        $sql = "SELECT *,Wins/(Wins+Losses+Draws)*100 AS Ranking FROM Highscore ORDER BY Ranking DESC"; //ORDER BY Ranking DESC (damit bester oben)
        $result = mysqli_query($tunnel, $sql) or die($ordiestring); //Tunnel unterstrichen, da bei debug nicht definiert.

        if (mysqli_num_rows($result) == 0) {
            echo "Keine Einträge vorhanden!";
        } else {
            //usort($result, repCompare(calcReputation($result['Wins'], $result['Losses']), calcReputation($result['Wins'], $result['Losses']))); //nicht mit $row[''] weil ja für jedes Element zu vergleichen
            $n = 0; //Ranking
            while ($row = mysqli_fetch_array($result)) {
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
                    </div>";
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