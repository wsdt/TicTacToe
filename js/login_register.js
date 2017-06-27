/**
 * Created by 1610653212 on 20.06.2017.
 */
//REGISTER-Form
function reg_onSubmit() { //Vor Absenden des Formulars prüfe...
    var username = document.getElementById('username');
    var password = document.getElementById('password');
    var passwordrepeat = document.getElementById('passwordrepeat');


    if (username.value === "" || password.value === "" || passwordrepeat.value === "") {
        show_notification('#ff0000', 'Es darf kein Eingabefeld leer sein!');
        return false;
    } else if (password.value !== passwordrepeat.value) {
        show_notification('#000', 'Das Passwort stimmt mit der Kontrolleingabe nicht überein!');
        return false;
    } else if (password.value.length < 4) {
        show_notification('#000', 'Das Passwort muss länger als 3 Zeichen sein!');
        return false;
    } else if (username.value.length < 4) {
        show_notification('#000', 'Der Username muss länger als 3 Zeichen sein!');
        return false;
    }
    return true; // return false to cancel form action
}


//LOGIN-Form
function showLoginForm() {
    $('#login-modal').modal({backdrop: 'static', keyboard: false}); //Login-Form nicht schließen wenn auf die Seite geklickt wird. 
    window.setTimeout(isLoggedIn, 200); //Execute to adapt the label, but wait a short time
}

function hideLoginForm() {
    $('#login-modal').modal('hide');
    window.setTimeout(isLoggedIn, 200); //Execute to adapt the label
}

//Label Login/Logout prüfen
function isLoggedIn() {
    var isVisible = $('#login-modal').is(":visible"); //Prüfe ob Loginbox sichtbar
    if (isVisible) {
        //console.log("Login Modal visible: "+isVisible);
        document.getElementById('login_logout_label_link').value = "Login"; //Zeige an, dass man sich einloggen kann
        document.getElementById('label_loggedinas').style.display = "none"; //Verstecke, dass als User X angemeldet
        document.getElementById('login_logout_label_link').className = "btn btn-primary"; //Ändere Buttonstyle
        //document.getElementById('login_logout_label_link').onclick = "showLoginForm()"; //Ändere Onclick Property
    } else {
        //console.log("Login Modal visible 2: "+isVisible);
        document.getElementById('login_logout_label_link').value = "Logout";
        document.getElementById('login_logout_label_link').className = "btn btn-danger";
        document.getElementById('label_loggedinas').style.display = "inline";
        //document.getElementById('login_logout_label_link').onclick = "hideLoginForm()";
    }
}

function logout_procedure() { //Login Procedure is in functions.php als PHP-Function (below generating the login-form)
    //Unset Cookies bzw. lasse sie ablaufen
    document.cookie = 'ttt_username' + '=; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
    document.cookie = 'ttt_password' + '=; expires=Thu, 01 Jan 1970 00:00:01 GMT;';

    showLoginForm(); //Zeige Login Formular und passe Buttons, Anzeige etc. an (also Username etc. wird nicht mehr angezeigt)
    show_notification('#000', 'Sie haben sich erfolgreich ausgeloggt.');
}

//Login-Form-Validation
function validateLoginCredentials() {
    var loggedInSuccessfully = false;

    //JS Prüfung vor PHP-Prüfung
    var username = document.getElementById('log_username');
    var password = document.getElementById('log_password');

    if (username.value === "" || password.value === "") {
        show_notification('#000', 'Bitte geben Sie ein Passwort oder einen Benutzer ein!');
        return false;
    }
    return true; // return false to cancel form action


    /*//Hier über durch PHP-Datenbankprüfung (Login.php) prüfen ob erfolgreich, dann hier bool auf true
    //ALSO IRGENDWIE AUF RESULT VON ACTION DARAUF ZUGREIFEN

    if (loggedInSuccessfully) {
        hideLoginForm();
    } else {
        if (!$('#login-modal').is(":visible")) {
            showLoginForm(); //Show Login form if login unsuccessful and form is hidden (should not be possible, but ok who knows)
        }
    }*/
}


