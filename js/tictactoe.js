// Lightbox
function closebox() {
  document.getElementById('overlayLogin').style.display = "none";
  document.getElementById('overlay').style.display = "none";
}

//Start-Game
function playGame(modus) {
  console.log("Try to start Game; Mode: "+modus); //0 = Single Player ; 1 = Multiplayer
  if (modus == 0) {
    document.getElementById('bt_singleplayer').className = "btn btn-primary"; //Active and Deactivate Button (Style)
    document.getElementById('bt_multiplayer').className = "btn btn-default";
    playGameSingleplayer(); //Start Game
  } else if (modus == 1) {
    document.getElementById('bt_singleplayer').className = "btn btn-default";
    document.getElementById('bt_multiplayer').className = "btn btn-primary";
    playGameMultiplayer();
  } else {
    document.getElementById('bt_singleplayer').className = "btn btn-default";
    document.getElementById('bt_multiplayer').className = "btn btn-default";
    console.error("Game Mode NOT FOUND!");
  }
}

function playGameSingleplayer() {
  //Firstly stop prev game (with[out] saving in database) if game is active
  //document.getElementById('ttt_square2').innerHTML = "O";
}

function playGameMultiplayer() {
  //Firstly stop prev game (with[out] saving in database) if game is active

}


//Resize set Attributes (X/O) in TTT-Field
/*
window.onload = function() {
  for (let i of document.getElementsByClassName('ttt_square')) {
    var oDiv = i;
    oDiv.style.overflow = "auto"; //for Firefox, but won't ruin for other browsers
    var fontSize = 50;
    var changes = 0;
    var blnSuccess = true;
    while (oDiv.scrollWidth <= oDiv.clientWidth) {
      oDiv.style.fontSize = fontSize + "px";
      fontSize++;
      changes++;
      if (changes > 500) {
        //failsafe..
        blnSuccess = false;
        break;
      }
    }
    if (changes > 0) {
      //upon failure, revert to original font size:
      if (blnSuccess)
        fontSize -= 2;
      else
        fontSize -= changes;
      oDiv.style.fontSize = fontSize + "px";
    }
  }
};*/
