/**
 * Created by kevin on 27.06.2017.
 */

var variableToSendToPHP = "Value to send";

jQuery(document).ready(function() {

    $('.clickMe').click(function () {
        $.ajax({
            url: "highscore.php",
            method: "post",
            data: {parameterInPostName: variableToSendToPHP},
            success: function (receivedData) {
                console.log(receivedData);
            }
        });
    });

});
