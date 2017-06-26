<?php
/**
 * Created by IntelliJ IDEA.
 * User: 1610653212
 * Date: 20.06.2017
 * Time: 12:33
 */

//Require JS-Login-Register-Functions 
echo "<script type='text/javascript' src='js/login_register.js'></script>";
require_once 'user.php';


//NOTIFICATION BAR
function createNotificationBar() {
   echo "<div id=\"notification\"><span id=\"notification_text\">ERROR: This should not be shown. Please contact system-administrator. </span><div id=\"close_notfication\" onclick=\"close_notification();\">X</div></div>";
}

//Generate TTT-Field
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
    //TODO: Hidden Form Field with all rounds results OR AJAX
    //erst aufrufen über formular
	//Mit SQL Statement INSERT INTO (gleich wie eine Abfrage)

    require "db/dbNewConnection.php";
    //Spiel in die Highscore-Liste einfügen
    if(isset($_GET['username']) && isset($_GET['score']) && isset($_GET['score'])) {

        $username = strip_tags(mysqli_real_escape_string($tunnel, $_GET['username']));
        $wins = strip_tags(mysqli_real_escape_string($tunnel, $_GET['wins']));
        $draws = strip_tags(mysqli_real_escape_string($tunnel, $_GET['draws']));
        $losses = strip_tags(mysqli_real_escape_string($tunnel, $_GET['losses']));
        $sql = mysqli_query($tunnel, "INSERT INTO highscore (`platzierung`,`username`,`wins`, `draws`, `losses`, `ratio`) VALUES ('','$username','$wins', '$draws', '$losses');");

        if($sql){
            echo 'Your score was saved. Congrats!';
        }else{
            echo 'There was a problem saving your score. Please try again later.'.mysqli_error($tunnel);;
        }
    }else{
        echo 'Your name or score wasnt passed in the request.';
    }



}

function deleteHighscoreEntry() {
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
        usort($result, repCompare(calcReputation($result['Wins'], $result['Losses']), calcReputation($result['Wins'], $result['Losses']))); //nicht mit $row[''] weil ja für jedes Element zu vergleichen

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

    if (isset($_POST['login'])) { //Wenn Login-Form abgesendet, dann prüfe Login-Daten
        /*
        Alternative Implementierung über CREATE USER in Datenbank, dann über SQL-Details direkt bei der Datenbank anmelden.
        So keine eigene User-Tabelle mehr notwendig (nur noch Highscore-Tabelle) und die Verschlüsselung wird ebenfalls nicht
        mehr notwendig. Habe (Kevin R.) dies in unserem Data-Engineering Projekt mit zusätzlicher Cookie-Unterstützung implementiert.

        */

        //Wenn etwas eingegeben wurde, wird Username und Passwort überprüft
        if (!empty($_POST['username']) && !empty($_POST['password'])) {

            require("db/dbNewConnection.php"); //Wenn Datenbankverbindung gescheitert wird folgender Code durch die bzw. fatal error nicht mehr ausgeführt

            $loginFAILURE_msg = 'Ihr Username oder/und Passwort ist falsch!';
            $username = mysqli_real_escape_string($tunnel, $_POST['username']);
            $password = mysqli_real_escape_string($tunnel, $_POST['password']);


            $tmp_user = new User(); //Lade Nutzerprofil aus Datenbank
            $result_usersuche = $tmp_user->loadUser_from_DB($username); //Prüfe ob User vorhanden und wenn vorhanden, dann gib ihn zurück (sonst false)
            if ($result_usersuche != false) {
                $tmp_user = $result_usersuche; //Weise DB_User unserem lokal erstellten User zu
                if ($tmp_user->isPasswordValid($password)) {
                    echo "<script type='text/javascript'>show_notification('#00aa00','Willkommen zurück \'" . $tmp_user->getUsername() . "\'!');"; //Login erfolgreich
                    echo "hideLoginForm();</script>"; //Verstecke Login-Formular NUR wenn Passwort und Username korrekt, sonst bleibt es geladen.
                //TODO: Ohne Cookies gelöst, da bei Login einfach Lightbox versteckt wird, ist das ok ohne Cookies bzw. ohne Session?
                } else {
                    echo "<script type='text/javascript'>show_notification('#ff0000','" . $loginFAILURE_msg . " (2)')</script>"; //Passwort stimmt nicht mit Username überein
                }
            } else {
                echo "<script type='text/javascript'>show_notification('#ff0000','" . $loginFAILURE_msg . " (1)')</script>"; //Nutzer nicht verraten, dass User nicht gefunden
            }
        $tmp_user->closeDBConnection($tunnel);
        }
    }
}
?>


