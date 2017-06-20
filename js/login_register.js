/**
 * Created by 1610653212 on 20.06.2017.
 */

//LOGIN-Form
function showLoginForm() {
    //$(window).on('load',function(){
    $('#login-modal').modal({backdrop: 'static', keyboard: false});
    window.setTimeout(isLoggedIn,200); //Execute to adapt the label
    //});
}

function hideLoginForm() {
    $('#login-modal').modal('hide');
    window.setTimeout(isLoggedIn,200); //Execute to adapt the label
}

//Label Login/Logout prüfen
function isLoggedIn() {
    var isVisible = $('#login-modal').is(":visible");
    if (isVisible) {
        console.log("Login Modal visible: "+isVisible);
        document.getElementById('login_logout_label_link').innerHTML = "Login"; //Zeige an, dass man sich einloggen kann
        document.getElementById('label_loggedinas').style.display = "none"; //Verstecke, dass als User X angemeldet
    } else {
        console.log("Login Modal visible 2: "+isVisible);
        document.getElementById('login_logout_label_link').innerHTML = "Logout";
        document.getElementById('label_loggedinas').style.display = "inline";
    }
}


