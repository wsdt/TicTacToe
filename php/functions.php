<?php
/**
 * Created by IntelliJ IDEA.
 * User: 1610653212
 * Date: 20.06.2017
 * Time: 12:33
 */

echo "<script type='text/javascript' src='js/login_register.js'></script>";
//require_once('db/dbNewConnection.php');

//NOTIFICATION BAR
function createNotificationBar() {
   echo "<div id=\"notification\"><span id=\"notification_text\">ERROR: This should not be shown. Please contact system-administrator. </span><div id=\"close_notfication\" onclick=\"close_notification();\">X</div></div>";
}

//TTT-Field
function createTTTField() {
    $z = 0;
    for ($i=1;$i<=3;$i++) {
        echo "<div class='row ttt_row' id='ttt_row".$i."'>\n"; echo "<!-- ".$i.". Row of TTT-Field -->\n";
        for ($j=1;$j<=3;$j++) {
            $z++;
            echo "<div class='col-xs-4 col-md-4 ttt_square' id='ttt_square".($z)."' onclick=\"setZug('".($z)."');\">".
                "</div>"; //<img src='images/trans_squarefield.png' class='ttt_square_img'/>
        }
        echo "</div>\n";
    }
    echo "";
}


//HIGHSCORE ---------------------------------------------------------------------------------
function saveHighscoreEntry() {
    //TODO: Hidden Form Field with all rounds results
    //erst aufrufen über formular

}

function calcReputation($wins,$losses) {
    // WINS = 1 Punkte wert ; LOSSES = -1 Punkte wert ; DRAWS = 0 Punkt wert
    if (!isset($wins) || !isset($losses) || ($wins == 0 && $losses == 0)) { //wenn beide 0 sind auch, da sonst DIV/0
        return 0; //Initial 0 zur Fehlervermeidung
    } else {
        $all_games = $wins+$losses;
        $rep = ($wins-$losses)/$all_games;
        if ($rep > 1) { $rep = 1; } else if ($rep < -1) { $rep = -1; } //Wenn komische Rep-Werte, hier evtl. Fehlerquelle
        return $rep;
    }
}

function repCompare ($a, $b) { //Prüfe ob $a eine höhere Reputation (gib >0 zurück) oder eine kleinere hat als $b (gib <0 zurück)
    if ($a >= $b) { return 1; }
    else if ($a < $b) { return -1; }
    else {
        return "ERROR"; //Durch String wird Fehler erzeugt. Deshalb muss oben auch >= stehen, damit alle Fälle abgedeckt
    }
}

function generateHighscoreTable()
{
    //require_once 'db/SQL2PHP.php'; //declare variables

    //Generate headings
    echo "<div class=\"highscore_table_row_caption\">
                <div class=\"highscore_table_cell highscore_table_caption\">Ranking</div>
                <div class=\"highscore_table_cell highscore_table_caption\">Nickname</div>
                <div class=\"highscore_table_cell highscore_table_caption\">Wins/Draws/Losses</div>
                <div class=\"highscore_table_cell highscore_table_caption\">Message</div>
                <div class=\"highscore_table_cell highscore_table_caption\">Reputation <!-- Reputation = Win/Loss Ratio --></div>
            </div>";


    require_once "db/dbNewConnection.php";

    if (isset($tunnel)) {
        $ordiestring = "<p><strong>PHP Info: </strong>Abfrage war nicht möglich.</p>";

        $sql = "SELECT * FROM Highscore"; //ORDER BY Platzierung ASC, (Platzierung rausgenommen), da sonst bei neuem Eintrag evtl. alle Einträge neu reinzuspeichern
        $result = mysqli_query($tunnel, $sql) or die($ordiestring); //Tunnel unterstrichen, da bei debug nicht definiert.

        //TODO: Result nach reputation sortieren! MÜSSTE ERLEDIGT SEIN, nur noch Test notwendig
        //Ganze rows einfach chronolgisch in neues Array rein.
        $result = mysqli_fetch_array($result);
        usort($result, repCompare(calcReputation($result['Wins'], $result['Losses']), calcReputation($result['Wins'], $result['Losses']))); //nicht mit $row[''] weil ja für jedes Element zu vergleichen
        //Usort gibt Boolean zurück, also müsste Array selbst neu definiert werden

        $n = 0; //Ranking
        foreach ($result as $row) {
            //Declare variables
            //$row = json_decode($row,true);
            //$platzierung = $row->Platzierung;
            $username = $row['Username']; //$row->Username; Wenn mysqli_fetch_object dann so
            $message = $row['Message'];
            $wins = $row['Wins'];
            $draws = $row['Draws'];
            $losses = $row['Losses'];
            $reputation = calcReputation($wins, $losses);

            //IMPORTANT: Sort user list after Reputation BEFORE ECHO in FOR!! (NICHT NOTWENDIG, da PLATZIERUNG IN DATENBANK GESPEICHERT!)
            echo "<div class=\"highscore_table_row\">
                <div class=\"highscore_table_cell\">" . (++$n) . "</div>
                <div class=\"highscore_table_cell\">" . $username . "</div>
                <div class=\"highscore_table_cell\">" . $wins . "/" . $draws . "/" . $losses . "</div>
                <div class=\"highscore_table_cell\">" . $message . "</div>
                <div class=\"highscore_table_cell\">" . $reputation . "%</div>
            </div>"; //$platzierung (alt statt $n)
            //Datenbanktabelle Highscore muss in Datenbank nicht sortiert sein!! (ORDER BY Platzierung bei Ausgabe möglich)
        }
        mysqli_close($tunnel);
    } else {
        echo "<div class='highscore_table_row'>";
        for ($i=0;$i<5;$i++) {
            echo "<div class='highscore_table_db_err'><marquee>No DB Connection</marquee></div>";
        } echo "</div>";
    }
}


//CREATE LOGIN-FORM
function createLoginForm()
{
    echo "<div class=\"modal fade\" id=\"login-modal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\" aria-hidden=\"true\" style=\"display: none;\">
        <div class=\"modal-dialog\">
            <div class=\"loginmodal-container\">
                <h1>Login</h1><br>
                <form method=\"post\" action='" . $_SERVER['PHP_SELF'] . "' onsubmit='return validateLoginCredentials()'> 
       
                    <input type=\"text\" name=\"username\" placeholder=\"Username\" id='log_username' onfocus='close_notification()'>
                    <input type=\"password\" name=\"password\" placeholder=\"Passwort\" id='log_password' onfocus='close_notification()'>
                    <input type=\"submit\" name=\"login\" class=\"login loginmodal-submit\" value=\"Login\">
                </form>

                <div class=\"login-help\">
                    <a href=\"register.php\" target='_blank'\">Neu registrieren</a>
                </div>
            </div>
        </div>
    </div>";

    if (isset($_POST['login'])) {
        require("db/dbNewConnection.php"); //Wenn Datenbankverbindung gescheitert wird folgender Code durch die bzw. fatal error nicht mehr ausgeführt

        if (!empty($_POST['username']) && !empty($_POST['password'])) {
            $username = mysqli_real_escape_string($tunnel, $_POST['username']);
            $password = mysqli_real_escape_string($tunnel, $_POST['password']);
            $sql = mysqli_query($tunnel, "SELECT Passwort FROM Users WHERE username='.$username.'"); //nur nach Username suchen und hash zurückgeben lassen, wenn User existiert

            $loginFAILURE_msg = 'Ihr Username oder/und Passwort ist falsch!';
            if (empty($sql)) {
                echo "<script type='text/javascript'>show_notification('#ff0000','" . $loginFAILURE_msg . "')</script>"; //Nutzer nicht verraten, dass User nicht gefunden wird
            } else {

                if (password_verify($password, $sql)) {
                    session_start();
                    echo "<script type='text/javascript'>show_notification('#00aa00','Willkommen zurück \'" . $username . "\'!');"; //Login erfolgreich
                    echo "hideLoginForm();</script>"; //Verstecke Login-Formular NUR wenn Passwort und Username korrekt, sonst bleibt es geladen.
                } else {
                    echo "<script type='text/javascript'>show_notification('#ff0000','" . $loginFAILURE_msg . "')</script>"; //Passwort stimmt nicht mit Username überein
                }
            }
        }

        if (isset($tunnel)) {
            mysqli_close($tunnel);
        }
    }
}
?>


