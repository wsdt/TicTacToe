<?php

include("dbNewConnection.php");
session_start();

$message="";
if(!empty($_GET["login"])) {
    $result = mysqli_query($tunnel,"SELECT * FROM Users WHERE username='" . $_GET["username"] . "' and passwort = '". $_GET["passwort"]."'");
    $row  = mysqli_fetch_array($result);
    if(is_array($row)) {
        $_SESSION["username"] = $row['username'];
        echo "Anmeldung erfolgreich";
    } else {
        $message = "Invalid Username or Password!";
    }
}
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <title>TicTacToe</title>
    <meta charset="utf-8">
    <link href="bootstrap/docs/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="bootstrap/docs/dist/css/bootstrap-theme.min.css" rel="stylesheet"/>
    <link href="bootstrap/bootstrap-social-gh-pages/bootstrap-social.css" rel="stylesheet"/>
    <link href="css/tictactoe.css" rel="stylesheet">

    <script type="text/javascript" src="js/tictactoe.js"></script>
    <script type="text/javascript" src="jquery/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="bootstrap/dist/js/bootstrap.min.js"></script>

    <?php
        function createTTTField() {
            for ($i=1;$i<=3;$i++) {
                echo "<div class='row ttt_row' id='ttt_row".$i."'>"; echo "<!-- ".$i.". Row of TTT-Field -->";
                for ($j=1;$j<=3;$j++) {
                    echo "<div class='col-xs-4 col-md-4 ttt_square' id='ttt_square".($j*$i)."'>".
                        "<img src='images/trans_squarefield.png' class='ttt_square_img'/></div>";
                }
                echo "</div>";
            }
            echo "";
        }
    ?>

</head>
<body>
<a href="#" data-toggle="modal" data-target="#login-modal">Login</a>
<header>
    <div class="row toprow">
        <div class="col-xs-11 col-md-11">
            <!-- Say who you are (only when you are logged in) [when not: class="hidden" OR class="show"-->
            <span class="show" id="label_loggedinas">Logged in as <strong>'CrazyHackerGuy'</strong></span>
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
        <input type="button" onclick="playGame(0)" value="Single Player" class="btn btn-default" id="bt_singleplayer"/>
        <input type="button" onclick="playGame(1)" value="Multiplayer" class="btn btn-default" id="bt_multiplayer"/>
    </div>

    <!-- HIGHSCORE
    TODO: Use DivID 'highscore_anchor' as an anchor (lightbox etc.) and scroll with a transition down -->
    <div id="highscore_anchor" class="row"> <!-- Highscore is placed in one 'row' -->
        <div class="col-xs-2 col-md-2"><!-- let empty --></div>
        <div class="col-xs-8 col-md-8" id="highscore_table">
            <!-- HERE is the highscore table placed (table layout as div) -->
            <div class="highscore_table_row_caption">
                <div class="highscore_table_cell highscore_table_caption">Ranking</div>
                <div class="highscore_table_cell highscore_table_caption">Nickname</div>
                <div class="highscore_table_cell highscore_table_caption">Punkte</div>
                <div class="highscore_table_cell highscore_table_caption">Message</div>
                <div class="highscore_table_cell highscore_table_caption">Reputation <!-- Reputation = Win/Loss Ratio --></div>
            </div>
            <!-- TODO: Ab hier mit PHP Zeilen dynamisch erzeugen -->
            <div class="highscore_table_row">
                <div class="highscore_table_cell">1</div>
                <div class="highscore_table_cell">WSDT</div>
                <div class="highscore_table_cell">4/ 5</div>
                <div class="highscore_table_cell">Hallo I bims</div>
                <div class="highscore_table_cell">88.5 %</div>
            </div>
            <div class="highscore_table_row">
                <div class="highscore_table_cell">2</div>
                <div class="highscore_table_cell">Ernesto</div>
                <div class="highscore_table_cell">5/ 5</div>
                <div class="highscore_table_cell">Wo ist meine Schokolade</div>
                <div class="highscore_table_cell">100 %</div>
            </div>

        </div>
        <div class="col-xs-2 col-md-2"><!-- let empty --></div>
    </div>
</main>
<footer>
    <!-- Follow us - Social Buttons -->
    <div class="col-xs-5 col-md-5"><!-- let empty --></div>
    <div id="socialbuttons" class="col-xs-2 col-md-2">
        <!-- TODO: Social-Icons werden nicht angezeigt -->
        <div id="fb_button" class="btn btn-block btn-social btn-facebook"><span class="fa fa-facebook"></span> Facebook</div>&nbsp;
        <div id="tw_button" class="btn btn-block btn-social btn-twitter"><span class="fa fa-twitter"></span> Twitter</div>&nbsp;
        <div id="yt_button" class="btn btn-block btn-social btn-github"><span class="fa fa-github"></span> Github</div>&nbsp;
        <div id="ig_button" class="btn btn-block btn-social btn-instagram"><span class="fa fa-instagram"></span> Instagram</div>
        <!-- If you want more Social-Media-Buttons: (Classes here)
        https://lipis.github.io/bootstrap-social/
        -->
    </div>
    <div class="col-xs-5 col-md-5"><!-- let empty --></div>

    <div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="loginmodal-container">
                <h1>Login</h1><br>
                <form method="get" action="">
                    <input type="text" name="username" placeholder="Username">
                    <input type="password" name="passwort" placeholder="Passwort">
                    <input type="submit" name="login" class="login loginmodal-submit" value="Login">
                </form>

                <div class="login-help">
                    <a href="register.php" target="_blank">Neu registrieren</a>
                </div>
            </div>
        </div>
    </div>
</footer>
</body>
</html>
