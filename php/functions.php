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


//HIGHSCORE
function calcReputation($wins,$draws,$losses) {
    // WINS = 3 Punkte wert ; LOSSES = -4 Punkte wert ; DRAWS = 1 Punkt wert
    if (!isset($wins) || !isset($losses) || !isset($draws) || $w) {
        return 0; //Initial 0 zur Fehlervermeidung
    } else {
        $all_games = $wins+$draws+$losses;
        $rep = ($wins/$all_games)*3 + ($draws/$all_games) - (($losses/$all_games)*4);
        return ($rep > 100) ? 100 : $rep;
    }
}

function repCompare ($a, $b) { //Prüfe ob $a eine höhere Reputation (gib >0 zurück) oder eine kleinere hat als $b (gib <0 zurück)
    if ($a >= $b) { return 1; }
    else if ($a < $b) { return -1; }
    else {
        return "ERROR"; //Durch String wird Fehler erzeugt. Deshalb muss oben auch >= stehen, damit alle Fälle abgedeckt
    }
}

function generateHighscoreTable() {
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

    $ordiestring = "<p><strong>PHP Info: </strong>Abfrage war nicht möglich.</p>";

    $sql = "SELECT * FROM Highscore"; //ORDER BY Platzierung ASC, (Platzierung rausgenommen), da sonst bei neuem Eintrag evtl. alle Einträge neu reinzuspeichern
    $result = mysqli_query($tunnel, $sql) or die($ordiestring); //Tunnel unterstrichen, da bei debug nicht definiert.

    //TODO: Result nach reputation sortieren! MÜSSTE ERLEDIGT SEIN, nur noch Test notwendig
    //Ganze rows einfach chronolgisch in neues Array rein.
    $result = mysqli_fetch_array($result);
    usort($result,repCompare(calcReputation($result['Wins'],$result['Draws'],$result['Losses']),calcReputation($result['Wins'],$result['Draws'],$result['Losses']))); //nicht mit $row[''] weil ja für jedes Element zu vergleichen
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
        $reputation = calcReputation($wins, $draws, $losses);

        //IMPORTANT: Sort user list after Reputation BEFORE ECHO in FOR!! (NICHT NOTWENDIG, da PLATZIERUNG IN DATENBANK GESPEICHERT!)
        echo "<div class=\"highscore_table_row\">
                <div class=\"highscore_table_cell\">".(++$n)."</div>
                <div class=\"highscore_table_cell\">".$username."</div>
                <div class=\"highscore_table_cell\">".$wins."/".$draws."/".$losses."</div>
                <div class=\"highscore_table_cell\">".$message."</div>
                <div class=\"highscore_table_cell\">".$reputation."%</div>
            </div>"; //$platzierung (alt statt $n)
        //Datenbanktabelle Highscore muss in Datenbank nicht sortiert sein!! (ORDER BY Platzierung bei Ausgabe möglich)
    }

    if (isset($tunnel)) {
        mysqli_close($tunnel);
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
    </div>"; //TODO: Add ?success=true to action unter '' damit unten geprüft werden kann ob Login Box erzeugt (wenn nicht reingegangen wird)

    //Hier NICHT schon Funktionsklammer schließen (wie vorhin), sonst wird Folgendes immer ausgeführt in jeder Datei

    if (isset($_POST['login'])) { //TODO: Wenn er in diese IF gar nicht rein geht, dann versuch if($_GET['success']==true), dafür musst du aber das Kommentar direkt hier vorher ausführen (ca. Zeile 103)
        require("db/dbNewConnection.php"); //Wenn Datenbankverbindung gescheitert wird folgender Code durch die bzw. fatal error nicht mehr ausgeführt

        if (!empty($_POST['username']) && !empty($_POST['password'])) {
            $username = mysqli_real_escape_string($tunnel, $_POST['username']);
            $password = mysqli_real_escape_string($tunnel, $_POST['password']);
            $hash = mysqli_query($tunnel, "SELECT username FROM Users WHERE username='.$username.'"); //nur nach Username suchen und hash zurückgeben lassen, wenn user existiert
            //TODO: Wichtig ist, dass beim Registrieren keine doppelten Usernamen erlaubt werden! Sonst kommen hier Fehlermeldungen auf

            //Da normal Login nur auf Startseite, wird angenommen, dass Notification Bar bereits erzeugt wurde
            $loginFAILURE_msg = 'Ihr Username oder/und Passwort ist falsch!';
            if (empty($hash)) {
                echo "<script type='text/javascript'>show_notification('#ff0000','" . $loginFAILURE_msg . "')</script>"; //Nutzer nicht verraten, dass User nicht gefunden
            } else {
                if (password_verify($password, $hash)) {
                    session_start(); //Habs mal drin gelassen, wird schon was mit deinen Session Variablen zu tun haben
                    echo "<script type='text/javascript'>show_notification('#00aa00','Willkommen zurück \'" . $username . "\'!');"; //Login erfolgreich
                    echo "hideLoginForm();</script>"; //Verstecke Login-Formular NUR wenn Passwort und Username korrekt, sonst bleibt es geladen.
                } else {
                    echo "<script type='text/javascript'>show_notification('#ff0000','" . $loginFAILURE_msg . "')</script>"; //Passwort stimmt nicht mit Username überein
                }
            }
        }


        /*TODO: Meine Vermutung, dass bei WHERE password='.$password.' (Punkte nicht vergessen), Folgendes geprüft wird:
          TODO  'eingegebenesPasswortInKlartext' == 'verschlüsseltesPasswortInDatenbank' --> also --> '1234' == 'ds16d65rsfd565r55r'
        */
        /*$existUserQuery = mysqli_query($tunnel,"SELECT username FROM Users WHERE username='.$username.' AND password='.$password.'");

        if(mysqli_num_rows($existUserQuery) > 0) {
            $_SESSION['username'] = $username;
        }
        else {
            echo'<p id="close_notfication">Benutzername oder Passwort falsch</p>';
        }

    }
    else {
        echo'<p id="close_notfication">Alle Felder ausfüllen.</p>';
    }*/


    }
    //echo "<script type='text/javascript'>hideLoginForm();</script>";

    if (isset($tunnel)) {
        mysqli_close($tunnel);
    }
}
?>


