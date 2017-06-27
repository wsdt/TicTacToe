<?php
/**
 * Created by IntelliJ IDEA.
 * User: kevin
 * Date: 27.06.2017
 * Time: 15:22
 */
require_once 'highscore.php';


/*var_dump($_POST);
var_dump($_COOKIE);*/


if (!empty($_POST['username']) && !isset($_POST['wins']) && !isset($_POST['draws']) && !isset($_POST['losses'])) { //Use ISSET because empty() gives empty(0) = true
    //IMPORTANT: USERNAME = eingeloggter User (trotzdem prüfen ob User existiert, da sonst DB-Error)
    //BESSER: Prüfe ob Username = $_COOKIE['ttt_username']
    if (!empty($_COOKIE['ttt_username']) && !empty($_COOKIE['ttt_password'])) {
        if ($_COOKIE['ttt_username'] == $_POST['username']) {
            echo "ok 1";
            DB_saveHighscoreEntry($_POST['username'], $_POST['wins'], $_POST['draws'], $_POST['losses']); //Speichere Highscore-Eintrag
        } else {
            echo "FAIL: Cookie does not correspond to username.";
        }
    } else {
        echo "FAIL: Could not save highscore entry (1).";
    }//Do nothing when User isn't valid bzw. does not exist
}