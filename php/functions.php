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
    return 0; //TODO: Formel für Reputation
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

    $sql = "SELECT * FROM Highscore ORDER BY Platzierung ASC";
    $result = mysqli_query($tunnel, $sql) or die($ordiestring);

    while ($row = mysqli_fetch_object($result)) {
        //Declare variables
        //$row = json_decode($row,true);
        $platzierung = $row->Platzierung;
        $username = $row->Username;
        $message = $row->Message;
        $wins = $row->Wins;
        $draws = $row->Draws;
        $losses = $row->Losses;
        $reputation = calcReputation($wins, $draws, $losses);

        //IMPORTANT: Sort user list after Reputation BEFORE ECHO in FOR!! (NICHT NOTWENDIG, da PLATZIERUNG IN DATENBANK GESPEICHERT!)
        echo "<div class=\"highscore_table_row\">
                <div class=\"highscore_table_cell\">".$platzierung."</div>
                <div class=\"highscore_table_cell\">".$username."</div>
                <div class=\"highscore_table_cell\">".$wins."/".$draws."/".$losses."</div>
                <div class=\"highscore_table_cell\">".$message."</div>
                <div class=\"highscore_table_cell\">".$reputation."%</div>
            </div>";
        //Datenbanktabelle Highscore muss in Datenbank nicht sortiert sein!! (ORDER BY Platzierung bei Ausgabe möglich)
    }
    mysqli_close($tunnel);

}


//CREATE LOGIN-FORM
function createLoginForm()
{
    echo "<div class=\"modal fade\" id=\"login-modal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\" aria-hidden=\"true\" style=\"display: none;\">
        <div class=\"modal-dialog\">
            <div class=\"loginmodal-container\">
                <h1>Login</h1><br>
                <form method=\"post\" action='" . $_SERVER['PHP_SELF'] . "?success=true' onsubmit='return validateLoginCredentials()'>
       
                    <input type=\"text\" name=\"username\" placeholder=\"Username\" id='log_username' onfocus='close_notification()'>
                    <input type=\"password\" name=\"password\" placeholder=\"Passwort\" id='log_password' onfocus='close_notification()'>
                    <input type=\"submit\" name=\"login\" class=\"login loginmodal-submit\" value=\"Login\">
                </form>

                <div class=\"login-help\">
                    <a href=\"register.php\" target='_blank'\">Neu registrieren</a>
                </div>
            </div>
        </div>
    </div>"; //Add ?debug=1 to action unter '' damit Datenbank ausgeschlossen wird
  }


include("db/dbNewConnection.php");
session_start();

if(isset($_POST['login'])) {

    if(!empty($_POST['username']) && !empty($_POST['password'])) {
        $username = mysqli_real_escape_string($tunnel,$_POST['username']);
        $password = mysqli_real_escape_string($tunnel,$_POST['password']);

        /*TODO: Meine Vermutung, dass bei WHERE password='.$password.' (Punkte nicht vergessen), Folgendes geprüft wird:
            'eingegebenesPasswortInKlartext' == 'verschlüsseltesPasswortInDatenbank' --> also --> '1234' == 'ds16d65rsfd565r55r'
        */
        $existUserQuery = mysqli_query($tunnel,"SELECT username FROM Users WHERE username='.$username.' AND password='.$password.'");

        if(mysqli_num_rows($existUserQuery) > 0) {
            $_SESSION['username'] = $username;
        }
        else {
            echo'<p id="close_notfication">Benutzername oder Passwort falsch</p>';
        }

    }
    else {
        echo'<p id="close_notfication">Alle Felder ausfüllen.</p>';
    }


}
echo "<script type='text/javascript'>hideLoginForm();</script>";


?>


