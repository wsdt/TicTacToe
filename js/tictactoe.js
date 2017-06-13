// Lightbox
function closebox() {
  document.getElementById('overlayLogin').style.display = "none";
  document.getElementById('overlay').style.display = "none";
}

//Start-Game
function changeMode(modus) {
  console.log("Try to change Gamemode; Mode: "+modus); //0 = Single Player ; 1 = Multiplayer
  if (modus == 0) {
    document.getElementById('bt_singleplayer').className = "btn btn-primary"; //Active and Deactivate Button (Style)
    document.getElementById('bt_multiplayer').className = "btn btn-default";
    restartGame();
  } else if (modus == 1) {
    document.getElementById('bt_singleplayer').className = "btn btn-default";
    document.getElementById('bt_multiplayer').className = "btn btn-primary";
    restartGame();
  } else {
    document.getElementById('bt_singleplayer').className = "btn btn-default";
    document.getElementById('bt_multiplayer').className = "btn btn-default";
    console.error("Game Mode NOT FOUND!");
    restartGame();
  }
}

function setZug(id) {
  var modus = 1;
  if (document.getElementById('bt_singleplayer').className == "btn btn-primary") {
    modus = 0;
    playGameSingleplayer(id);
  } else {
    playGameMultiplayer(id);
  }
}

function playGameSingleplayer(id) {
  if(document.getElementById('ttt_square'+id).innerHTML == field_content && turn == 0 && mode == 1) {
    document.getElementById('ttt_square'+id).innerHTML = 'X';
    sqr1T = 1;
    turn = 1;
    vari();
    check();
  } else if(document.getElementById('ttt_square'+id).innerHTML == field_content && turn == 1 && mode == 2) {
    document.getElementById('ttt_square'+id).innerHTML = 'X';
    sqr1T = 1;
    turn = 0;
    vari();
    player1Check();
  } else if(document.getElementById('ttt_square'+id).innerHTML == field_content && turn == 0 && mode == 2) {
    document.getElementById('ttt_square'+id).innerHTML = 'O';
    sqr1T = 1;
    turn = 1;
    vari();
    player1Check();
  }
  drawCheck();  
}

function playGameMultiplayer(id) {
  //Firstly stop prev game (with[out] saving in database) if game is active

}

function restartGame() {
  for (tmp of document.getElementsByClassName('ttt_square')) {
    tmp.innerHTML = field_content;
  }
}

