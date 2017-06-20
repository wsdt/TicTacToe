<?php
/**
 * Created by IntelliJ IDEA.
 * User: 1610653212
 * Date: 20.06.2017
 * Time: 12:33
 */
//NOTIFICATION BAR
function createNotificationBar() {
   echo "<div id=\"notification\"><span id=\"notification_text\">ERROR: This should not be shown. Please contact system-administrator. </span><div id=\"close_notfication\" onclick=\"close_notification();\">X</div></div>";
}

function generateHighscoreTable() {
    //Generate headings
    echo "<div class=\"highscore_table_row_caption\">
                <div class=\"highscore_table_cell highscore_table_caption\">Ranking</div>
                <div class=\"highscore_table_cell highscore_table_caption\">Nickname</div>
                <div class=\"highscore_table_cell highscore_table_caption\">Punkte</div>
                <div class=\"highscore_table_cell highscore_table_caption\">Message</div>
                <div class=\"highscore_table_cell highscore_table_caption\">Reputation <!-- Reputation = Win/Loss Ratio --></div>
            </div>";

    echo "<!-- TODO: Ab hier mit PHP Zeilen dynamisch erzeugen -->
            <div class=\"highscore_table_row\">
                <div class=\"highscore_table_cell\">1</div>
                <div class=\"highscore_table_cell\">WSDT</div>
                <div class=\"highscore_table_cell\">4/ 5</div>
                <div class=\"highscore_table_cell\">Hallo I bims</div>
                <div class=\"highscore_table_cell\">88.5 %</div>
            </div>
            <div class=\"highscore_table_row\">
                <div class=\"highscore_table_cell\">2</div>
                <div class=\"highscore_table_cell\">Ernesto</div>
                <div class=\"highscore_table_cell\">5/ 5</div>
                <div class=\"highscore_table_cell\">Wo ist meine Schokolade</div>
                <div class=\"highscore_table_cell\">100 %</div>
            </div>";
}


//CREATE LOGIN-FORM
function createLoginForm() {
    if (empty($_POST)) {
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
                    <a href=\"php/register.php\" target=\"_blank\">Neu registrieren</a>
                </div>
            </div>
        </div>
    </div>"; //Add ?debug=1 to action unter '' damit Datenbank ausgeschlossen wird
    } else {
        //Prüfe ob User und Passwort etc ok
        $username = $_POST['username'];
        $password = $_POST['password'];

        echo $username.",".$password;


    }
}