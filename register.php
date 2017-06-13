<!DOCTYPE html>
<html lang="de">
<head>
    <title>Registrierung</title>
    <meta charset="utf-8">
    <link href="css/tictactoe.css" rel="stylesheet">
</head>
<body>
<div class="loginmodal-container">
    <h1>Neu registrieren</h1><br>
        <form method="get" action="php/insertNewUser.php" name="formreg">
            <input type="text" name="username" placeholder="Username">
            <input type="password" name="passwort" placeholder="Passwort">
            <input type="password" name="passwort2" placeholder="Passwort wiederholen">
            <input type="submit" name="submit" class="login loginmodal-submit" value="Registrieren">
        </form>
    </div>
</body>
</html>
