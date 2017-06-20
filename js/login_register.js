/**
 * Created by 1610653212 on 20.06.2017.
 */

//LOGIN-Form
function showLoginForm() {
    //$(window).on('load',function(){
    $('#login-modal').modal({backdrop: 'static', keyboard: false});
    isLoggedIn(); //Execute to adapt the label
    //});
}

function hideLoginForm() {
    $('#login-modal').modal('hide');
    isLoggedIn(); //Execute to adapt the label
}

//Label Login/Logout prüfen
function isLoggedIn() {
    if ($('#login-modal').is(":visible")) {
        document.getElementById('login_logout_label_link').innerHTML = "Login";
    } else {
        document.getElementById('login_logout_label_link').innerHTML = "Logout";
    }
}


