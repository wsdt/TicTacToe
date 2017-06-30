<!DOCTYPE html>
<html lang="de">
<head>
    <title>TicTacToe</title>
<?php
        require_once('php/head.php');
    ?>

</head>
<body> <!--onload="showLoginForm()" REMOVED HERE because JS from functions.php would be ignored. -->
<!-- Following code should be the first code after body -->
<?php

//Create Notification Bar
createNotificationBar();

//Show Login Form or login automatically and return user_object or -1 if error occurred
$user_object = createLoginForm();
?>
<!-- END first code after body -->
<!-- Login or Logout Button at the screen (OLD) -->
<!--<div id="login_logout_label"><a href="php/logout.php" data-toggle="modal" data-target="#login-modal" id="login_logout_label_link">Login</a></div>-->


<header>
    <div class="row toprow">
        <div class="col-xs-11 col-md-11">
            <!-- Say who you are (only when you are logged in) [when not: class="hidden" OR class="show"-->
            <span class="show_label" id="label_loggedinas">Logged in as <strong id="label_username"><?php if ($user_object instanceof User) {echo $user_object->getUsername();} //-1 if login failed ?></strong></span>
        </div>
        <div class="col-xs-1 col-md-1">
            <!--<form name="logout_form" action="php/logout.php" onsubmit="showLoginForm()">-->
                <input type="button" name="logout" class="btn-primary" id="login_logout_label_link" value="Log-Out" onclick="logout_procedure()"/>
            <!--</form>-->
            <!-- Generell showLoginForm(), da ohnehin nicht anklickbar wenn Loginform offen. -->
        </div>
    </div>
</header>
<main>
    <div class="row"> <!-- ROW: TicTacToe-Heading -->
        <div class="col-xs-3 col-xs-offset-4 col-md-3 col-md-offset-4"><h1 id="label_tictactoe">Tic Tac Toe</h1></div>
    </div>
    <div class="row"><!-- TicTacToe positionieren-->
        <div class="col-xs-3 col-xs-offset-4 col-md-3 col-md-offset-4" id="ttt_field">
            <!-- FIELD HERE -->
            <?php createTTTField(); ?>
        </div>
    </div>

    <!-- TTT-Mode -->
    <div class="row"><div class="col-xs-12 col-md-12"><!-- let empty --></div></div>
    <div id="play_buttons">
        <div onclick="changeDifficulty()" class="btn btn-default" id="bt_difficulty"></div>
        <input type="button" onclick="changeMode(0)" value="Single Player" class="btn btn-primary" id="bt_singleplayer"/>
        <input type="button" onclick="changeMode(1)" value="Multiplayer" class="btn btn-default" id="bt_multiplayer"/>
        <input type="button" onclick="restartGame()" value="Restart Game" class="btn btn-danger" id="bt_restart"/>
    </div>

    <!-- HIGHSCORE -->
    <div id="highscore_anchor" class="row"> <!-- Highscore is placed in one 'row' -->
        <div class="col-xs-8 col-xs-offset-2 col-md-6 col-md-offset-3" id="highscore_table">
            <!-- HERE is the highscore table placed (table layout as div) -->
            <?php DB_generateHighscoreTable(); ?>

        </div>
    </div>
</main>
<footer>
    <!-- SOCIAL-BUTTONS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <div id="socialbuttons" class="col-xs-12 col-md-12">
    <a href="https://www.facebook.com/sharer/sharer.php?u=http%3A//localhost/tictactoe/index.php" target="_blank" class="fa fa-facebook"></a>
    <a href="https://twitter.com/home?status=You%20have%20to%20try%20this%20awesome%20tic%20tac%20toe%20game!" target="_blank" class="fa fa-twitter"></a>
    <a href="http://github.com/wsdt/tictactoe" target="_blank" class="fa fa-github"></a>
    <a href="https://www.instagram.com/explore/tags/tictactoe/?hl=de" class="fa fa-instagram"></a>
    </div>

</footer>

</body>
</html>
