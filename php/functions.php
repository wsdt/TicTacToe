<?php
/**
 * Created by IntelliJ IDEA.
 * User: 1610653212
 * Date: 20.06.2017
 * Time: 12:33
 */

require_once('db/dbNewConnection.php');

//NOTIFICATION BAR
function createNotificationBar() {
   echo "<div id=\"notification\"><span id=\"notification_text\">ERROR: This should not be shown. Please contact system-administrator. </span><div id=\"close_notfication\" onclick=\"close_notification();\">X</div></div>";
}


//CREATE LOGIN-FORM
function createLoginForm()
{
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
    </div>";
    } else {
        //Prüfe ob User und Passwort etc ok
        session_start();
        $pdo = new PDO('mysql:host=localhost;db=tictactoe', 'root', '');

        if (isset($_GET['login'])) {
            $username = $_POST['username'];
            $passwort = $_POST['passwort'];

            $statement = $pdo->prepare("SELECT * FROM Users WHERE username = :username");
            $result = $statement->execute(array('username' => $username));
            $user = $statement->fetch();

            //Überprüfung des Passworts
            if ($user !== false && password_verify($passwort, $user['passwort'])) {
                $_SESSION['username'] = $user['username'];
                die('Login erfolgreich. Weiter zu <a href="../index.php">internen Bereich</a>');
            } else {
                $errorMessage = "E-Mail oder Passwort war ungültig<br>";
            }

        }
    }
}
		?>
