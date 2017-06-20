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


//CREATE LOGIN-FORM
function createLoginForm() {
    echo "<div class=\"modal fade\" id=\"login-modal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\" aria-hidden=\"true\" style=\"display: none;\">
        <div class=\"modal-dialog\">
            <div class=\"loginmodal-container\">
                <h1>Login</h1><br>
                <form method=\"get\" action=\"\">
                    <input type=\"text\" name=\"username\" placeholder=\"Username\">
                    <input type=\"password\" name=\"passwort\" placeholder=\"Passwort\">
                    <input type=\"submit\" name=\"login\" class=\"login loginmodal-submit\" value=\"Login\" onclick='validateLoginCredentials()'>
                </form>

                <div class=\"login-help\">
                    <a href=\"php/register.php\" target=\"_blank\">Neu registrieren</a>
                </div>
            </div>
        </div>
    </div>";
}