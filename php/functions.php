<?php
/**
 * Created by IntelliJ IDEA.
 * User: 1610653212
 * Date: 20.06.2017
 * Time: 12:33
 */

//Require JS-Login-Register-Functions 
//echo "<script type='text/javascript' src='js/login_register.js'></script>";
require_once 'user.php';
require_once 'highscore.php';


//NOTIFICATION BAR
function createNotificationBar()
{
    echo "<div id=\"notification\"><span id=\"notification_text\">ERROR: This should not be shown. Please contact system-administrator. </span><div id=\"close_notfication\" onclick=\"close_notification();\">X</div></div>";
}

//Generate TTT-Field
function createTTTField()
{
    $z = 0;
    for ($i = 1; $i <= 3; $i++) {
        echo "<div class='row ttt_row' id='ttt_row" . $i . "'>\n";
        echo "<!-- " . $i . ". Row of TTT-Field -->\n";
        for ($j = 1; $j <= 3; $j++) {
            $z++;
            echo "<div class='col-xs-4 col-md-4 ttt_square' id='ttt_square" . ($z) . "' onclick=\"setZug('" . ($z) . "');\">" .
                "</div>"; //<img src='images/trans_squarefield.png' class='ttt_square_img'/>
        }
        echo "</div>\n";
    }
    echo "";
}

//HIGHSCORE ---------------------------------------------------------------------------------
//TODO in class highscore





//CREATE LOGIN-FORM
function createLoginForm()
{
    echo "<div class=\"modal fade\" id=\"login-modal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\" aria-hidden=\"true\" style=\"display: none;\">
        <div class=\"modal-dialog\">
            <div class=\"loginmodal-container\">
                <h1>Login</h1><br>
                <form method=\"post\" action='" . $_SERVER['PHP_SELF'] . "' onsubmit='return validateLoginCredentials()'> 
       
                    <input type=\"text\" name=\"username\" placeholder=\"Username (not case-sensitive)\" id='log_username' onfocus='close_notification()'>
                    <input type=\"password\" name=\"password\" placeholder=\"Passwort\" id='log_password' onfocus='close_notification()'>
                    <input type=\"submit\" name=\"login\" class=\"login loginmodal-submit\" value=\"Login\">
                </form>

                <div class=\"login-help\">
                    <a href=\"register.php\" target='_blank'\">Neu registrieren</a>
                </div>
            </div>
        </div>
    </div>";

    echo "<script type='text/javascript'>showLoginForm();</script>"; //Lade LoginForm standardmäßig.

    if (!empty($_POST['login']) || (!empty($_COOKIE['ttt_username']) && !empty($_COOKIE['ttt_password']))) { //Wenn Login-Form abgesendet oder cookie verfügbar dann prüfe Login-Daten
        /*
        Alternative Implementierung über CREATE USER in Datenbank, dann über SQL-Details direkt bei der Datenbank anmelden.
        So keine eigene User-Tabelle mehr notwendig (nur noch Highscore-Tabelle) und die Verschlüsselung wird ebenfalls nicht
        mehr notwendig. Habe (Kevin R.) dies in unserem Data-Engineering Projekt mit zusätzlicher Cookie-Unterstützung implementiert.

        */

        //Wenn etwas eingegeben wurde, wird Username und Passwort überprüft
        //if ((!empty($_POST['username']) && !empty($_POST['password'])) || (!empty($_COOKIE['ttt_username'] && !empty($_COOKIE['ttt_password'])))) {

        require("db/dbNewConnection.php"); //Wenn Datenbankverbindung gescheitert wird folgender Code durch die bzw. fatal error nicht mehr ausgeführt

        $loginFAILURE_msg = 'Ihr Username oder/und Passwort ist falsch!';
        $isCookie = false;
        if ((!empty($_POST['username']) && !empty($_POST['password']))) {
            $username = mysqli_real_escape_string($tunnel, $_POST['username']);
            $password = mysqli_real_escape_string($tunnel, $_POST['password']);
        } else if ((!empty($_COOKIE['ttt_username']) && !empty($_COOKIE['ttt_password']))) {
            $username = mysqli_real_escape_string($tunnel, $_COOKIE['ttt_username']);
            $password = mysqli_real_escape_string($tunnel, $_COOKIE['ttt_password']);
            $isCookie = true;
        } else {
            echo "ERROR: Could not authentificate user. [in functions.php].";
            $username = null;
            $password = null; //Löse Exception aus
        }
        $tmp_user = new User(); //Lade Nutzerprofil aus Datenbank
        $result_usersuche = $tmp_user->loadUser_from_DB($username); //Prüfe ob User vorhanden und wenn vorhanden, dann gib ihn zurück (sonst false)
        if ($result_usersuche != false) {
            $tmp_user = $result_usersuche; //Weise DB_User unserem lokal erstellten User zu

            //Wenn Cookie vergleiche Hashes, sonst mit isPasswordValid()
            if ($isCookie) {
                ($tmp_user->getPasswordHash() == $password) ? $pw_valid = true : $pw_valid = false; //Prüfe ob Pwd dem Hash im User entspricht
            } else {
                ($tmp_user->isPasswordValid($password)) ? $pw_valid = true : $pw_valid = false; //Prüfe ob verschlüsseltes Pwd dem übergebenen Pwd (Klartext) entspricht
            }

            if ($pw_valid) {
                echo "<script type='text/javascript'>show_notification('#00aa00','Willkommen zurück \'" . $tmp_user->getUsername() . "\'!');"; //Login erfolgreich
                echo "hideLoginForm();</script>"; //Verstecke Login-Formular NUR wenn Passwort und Username korrekt, sonst bleibt es geladen.

                //Speichere Authentifizierungsdaten als Cookie
                setcookie("ttt_username", $tmp_user->getUsername(), time() + 86400); //Verfällt in 24h
                setcookie("ttt_password", $tmp_user->getPasswordHash(), time() + 86400); //Verfällt in 24h
                return $tmp_user; //Gib User-Objekt zurück
            } else {
                echo "<script type='text/javascript'>show_notification('#ff0000','" . $loginFAILURE_msg . " (2)')</script>"; //Passwort stimmt nicht mit Username überein
                return -1; //Gib Fehlercode -1 zurück
            }
        } else {
            echo "<script type='text/javascript'>show_notification('#ff0000','" . $loginFAILURE_msg . " (1)')</script>"; //Nutzer nicht verraten, dass User nicht gefunden
            return -1;
        }
        $tmp_user->closeDBConnection($tunnel);
    }
}

?>


