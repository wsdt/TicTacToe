/**
 * Created by 1610653212 on 20.06.2017.
 */
//REGISTER-Form
function reg_onSubmit() {
    var username = document.getElementById('username');
    var password = document.getElementById('password');
    var passwordrepeat = document.getElementById('passwordrepeat');


    if (username.value === "" || password.value === "" || passwordrepeat.value === "") {
        console.log("show warning");
        show_notification('#ff0000', 'Es darf kein Eingabefeld leer sein!');
        return false;
    } else if (password.value != passwordrepeat.value) {
        show_notification('#000', 'Das Passwort stimmt mit der Kontrolleingabe nicht überein!');
        return false;
    } else if (username.value.length < 4) {
        show_notification('#000', 'Der Username muss länger als 3 Zeichen sein!');
        return false;
    }
    return true; // return false to cancel form action
}


//LOGIN-Form
function showLoginForm() {
    //$(window).on('load',function(){
    $('#login-modal').modal({backdrop: 'static', keyboard: false});
    window.setTimeout(isLoggedIn, 200); //Execute to adapt the label
    //});
}

function hideLoginForm() {
    $('#login-modal').modal('hide');
    window.setTimeout(isLoggedIn, 200); //Execute to adapt the label
}

//Label Login/Logout prüfen
function isLoggedIn() {
    var isVisible = $('#login-modal').is(":visible");
    if (isVisible) {
        //console.log("Login Modal visible: "+isVisible);
        document.getElementById('login_logout_label_link').innerHTML = "Login"; //Zeige an, dass man sich einloggen kann
        document.getElementById('label_loggedinas').style.display = "none"; //Verstecke, dass als User X angemeldet
    } else {
        //console.log("Login Modal visible 2: "+isVisible);
        document.getElementById('login_logout_label_link').innerHTML = "Logout";
        document.getElementById('label_loggedinas').style.display = "inline";
    }
}

//Login-Form-Validation
function validateLoginCredentials() {
    var loggedInSuccessfully = false;

    //TODO: Hier über durch PHP-Datenbankprüfung (Login.php) prüfen ob erfolgreich, dann hier bool auf true

    if (loggedInSuccessfully) {
        hideLoginForm();
    } else {
        if (!$('#login-modal').is(":visible")) {
            showLoginForm(); //Show Login form if login unsuccessful and form is hidden (should not be possible, but ok who knows)
        }
    }
}


