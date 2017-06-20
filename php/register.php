<!DOCTYPE html>
<html lang="de">
<head>
    <title>Registrierung</title>
    <meta charset="utf-8">
    <link href="../css/tictactoe.css" rel="stylesheet">
    <?php require_once 'functions.php'; ?>
    <script type="text/javascript" src="../jquery/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="../js/tictactoe.js"></script>
    <script type="text/javascript" src="../js/login_register.js"></script>

</head>
<body>
<?php createNotificationBar(); ?>



<div class="loginmodal-container">
    <h1>Neu registrieren</h1><br>
        <form method="post" action="db/insertNewUser.php" name="formreg" id="formreg" onsubmit="return reg_onSubmit()">
            <input type="text" name="username" placeholder="Username" id="username" required onfocus="close_notification()">
            <input type="password" name="passwort" placeholder="Passwort" id="password" required onfocus="close_notification()">
            <input type="password" name="passwort2" placeholder="Passwort wiederholen" id="passwordrepeat" onfocus="close_notification()" required>
            <input type="submit" name="submit" class="login loginmodal-submit" value="Registrieren">
        </form>
    </div>
</body>
</html>
