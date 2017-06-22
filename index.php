

<!DOCTYPE html>
<html lang="de">
<head>
    <title>TicTacToe</title>
<?php
        require_once('php/head.php');
    ?>

</head>
<body onload="showLoginForm()">
<!-- Following code should be the first code after body -->
<?php
//Create Notification Bar
createNotificationBar();

//Show Login Form
createLoginForm();
?>
<!-- END first code after body -->
<!-- Login or Logout Button at the screen (OLD) -->
<!--<div id="login_logout_label"><a href="php/logout.php" data-toggle="modal" data-target="#login-modal" id="login_logout_label_link">Login</a></div>-->


<header>
    <div class="row toprow">
        <div class="col-xs-11 col-md-11">
            <!-- Say who you are (only when you are logged in) [when not: class="hidden" OR class="show"-->
            <span class="show_label" id="label_loggedinas">Logged in as <strong></strong></span>
        </div>
        <div class="col-xs-1 col-md-1">
            <!--<form name="logout_form" action="php/logout.php" onsubmit="showLoginForm()">-->
                <input type="button" name="logout" class="btn-primary" id="login_logout_label_link" value="Log-Out" onclick="showLoginForm()"/>
            <!--</form>-->
            <!-- Generell showLoginForm(), da ohnehin nicht anklickbar wenn Loginform offen. -->
        </div>
    </div>
</header>
<main>
    <div class="row"> <!-- ROW: TicTacToe-Heading -->
        <div class="col-xs-4 col-md-4"><!-- let empty --></div>
        <div class="col-xs-3 col-md-3"><h1 id="label_tictactoe">Tic Tac Toe</h1></div>
        <div class="col-xs-4 col-md-4"><!-- let empty --></div>
    </div>
    <div class="row">
        <div class="col-xs-4 col-md-4"><!-- let emtpy --></div>
        <div class="col-xs-1 col-md-1"><!-- WHICH ROUND FROM ROUNDS? (PHP/JS) -->
            <span><h3 id="label_roundofrounds">1 / 5</h3><!-- TODO: This has to be dynamic --></span>
        </div>
        <div class="col-xs-6 col-md-6"><!-- let empty --></div>
    </div>
    <div class="row"><!-- TicTacToe positionieren-->
        <div class="col-xs-4 col-md-4"><!-- let empty --></div>
        <div class="col-xs-3 col-md-3" id="ttt_field">
            <!-- FIELD HERE -->
            <?php createTTTField(); ?>
        </div>
        <div class="col-xs-5 col-md-5"><!-- let empty --></div>
    </div>

    <!-- TTT-Mode -->
    <div class="row"><div class="col-xs-12 col-md-12"><!-- let empty --></div></div>
    <div id="play_buttons">
        <div onclick="changeDifficulty()" class="btn btn-default" id="bt_difficulty"></div>
        <input type="button" onclick="changeMode(0)" value="Single Player" class="btn btn-primary" id="bt_singleplayer"/>
        <input type="button" onclick="changeMode(1)" value="Multiplayer" class="btn btn-default" id="bt_multiplayer"/>
        <input type="button" onclick="restartGame()" value="Restart Game" class="btn btn-danger" id="bt_restart"/>
    </div>

    <!-- HIGHSCORE
    TODO: Use DivID 'highscore_anchor' as an anchor (lightbox etc.) and scroll with a transition down -->
    <div id="highscore_anchor" class="row"> <!-- Highscore is placed in one 'row' -->
        <div class="col-xs-2 col-md-2"><!-- let empty --></div>
        <div class="col-xs-8 col-md-8" id="highscore_table">
            <!-- HERE is the highscore table placed (table layout as div) -->
            <?php generateHighscoreTable(); ?>

        </div>
        <div class="col-xs-2 col-md-2"><!-- let empty --></div>
    </div>
</main>
<footer>
    <!-- Follow us - Social Buttons -->
    <div class="col-xs-4 col-md-4"><!-- let empty --></div>
    <div id="socialbuttons" class="col-xs-4 col-md-4">
        <!-- TODO: Social-Icons werden nicht angezeigt -->
        <div id="fb_button" class="btn btn-block btn-social btn-facebook"><span class="fa fa-facebook"></span> Facebook</div>&nbsp;
        <div id="tw_button" class="btn btn-block btn-social btn-twitter"><span class="fa fa-twitter"></span> Twitter</div>&nbsp;
        <div id="yt_button" class="btn btn-block btn-social btn-github"><span class="fa fa-github"></span> Github</div>&nbsp;
        <div id="ig_button" class="btn btn-block btn-social btn-instagram"><span class="fa fa-instagram"></span> Instagram</div>
        <!-- If you want more Social-Media-Buttons: (Classes here)
        https://lipis.github.io/bootstrap-social/
        -->
    </div>
    <div class="col-xs-4 col-md-4"><!-- let empty --></div>


</footer>
</body>
</html>
