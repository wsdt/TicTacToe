<?php
if (empty($_GET["debug"])) {

    include("php/db/dbNewConnection.php");
    session_start();

    $message = "";
    if (!empty($_GET["login"])) {
        $result = mysqli_query($tunnel, "SELECT * FROM Users WHERE username='" . $_GET["username"] . "' and passwort = '" . $_GET["passwort"] . "'");
        $row = mysqli_fetch_array($result);
        if (is_array($row)) {
            $_SESSION["username"] = $row['username'];
            echo "Anmeldung erfolgreich";
        } else {
            $message = "Invalid Username or Password!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <title>TicTacToe</title>
<?php
        require_once('php/head.php');


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
    ?>

</head>
<body onload="showLoginForm()">
<!-- Following code should be the first code after body -->
<?php createNotificationBar(); ?>


<!--SHOW LOGIN FORM-->
<?php
createLoginForm();
?>
<!-- END first code after body -->
<!-- Login or Logout Button at the screen -->
<div id="login_logout_label"><a href="#" data-toggle="modal" data-target="#login-modal" id="login_logout_label_link">Login</a></div>


<header>
    <div class="row toprow">
        <div class="col-xs-11 col-md-11">
            <!-- Say who you are (only when you are logged in) [when not: class="hidden" OR class="show"-->
            <span class="show_label" id="label_loggedinas">Logged in as <strong>'CrazyHackerGuy'</strong></span>
        </div>
        <div class="col-xs-1 col-md-1">
            <form id="form_logout" name="form_logout" action="#">
                <!-- TODO: Evtl. mit PHP je nachdem ob eingeloggt oder nicht. Auch Action adden!-->
                <input type="submit" name="logout" class="btn-danger" value="Log-Out"/>
            </form>
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
            <!-- OLD-STATIC VERSION
            <div class="row ttt_row" id="ttt_row1"> <!-- 1. Row of TTT-Field
                <div class="col-xs-4 col-md-4 ttt_square" id="ttt_square1"></div>
                <div class="col-xs-4 col-md-4 ttt_square" id="ttt_square2"></div>
                <div class="col-xs-4 col-md-4 ttt_square" id="ttt_square3"></div>
            </div>
            <div class="row ttt_row" id="ttt_row2"> <!-- 1. Row of TTT-Field
                <div class="col-xs-4 col-md-4 ttt_square" id="ttt_square4"></div>
                <div class="col-xs-4 col-md-4 ttt_square" id="ttt_square5"></div>
                <div class="col-xs-4 col-md-4 ttt_square" id="ttt_square6"></div>
            </div>
            <div class="row ttt_row" id="ttt_row3"> <!-- 1. Row of TTT-Field
                <div class="col-xs-4 col-md-4 ttt_square" id="ttt_square7"></div>
                <div class="col-xs-4 col-md-4 ttt_square" id="ttt_square8"></div>
                <div class="col-xs-4 col-md-4 ttt_square" id="ttt_square9"></div>
            </div>-->
        </div>
        <div class="col-xs-5 col-md-5"><!-- let empty --></div>
    </div>

    <!-- TTT-Mode -->
    <div class="row"><div class="col-xs-12 col-md-12"><!-- let empty --></div></div>
    <div id="play_buttons">
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
