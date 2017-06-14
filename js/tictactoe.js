// Lightbox
function closebox() {
  document.getElementById('overlayLogin').style.display = "none";
  document.getElementById('overlay').style.display = "none";
}

//Start-Game
function changeMode(modus) {
  console.log("Try to change Gamemode; Mode: "+modus); //0 = Single Player ; 1 = Multiplayer
  if (modus === 0) {
    document.getElementById('bt_singleplayer').className = "btn btn-primary"; //Active and Deactivate Button (Style)
    document.getElementById('bt_multiplayer').className = "btn btn-default";
    restartGame();
  } else if (modus === 1) {
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
  if (document.getElementById('bt_singleplayer').className === "btn btn-primary") {
    modus = 0;
    playGameSingleplayer(id);
  } else {
    playGameMultiplayer(id);
  }
}

function playGameSingleplayer(id) {
  unsetVar();
  if(document.getElementById('ttt_square'+id).innerHTML === field_content && turn === 0 && mode === 1) {
    document.getElementById('ttt_square'+id).innerHTML = field_content+'X';
    sqr1T = 1;
    turn = 1;
    vari();
    check();
  } else if(document.getElementById('ttt_square'+id).innerHTML === field_content && turn === 1 && mode === 2) {
    document.getElementById('ttt_square'+id).innerHTML = field_content+'X';
    sqr1T = 1;
    turn = 0;
    vari();
    player1Check();
  } else if(document.getElementById('ttt_square'+id).innerHTML === field_content && turn === 0 && mode === 2) {
    document.getElementById('ttt_square'+id).innerHTML = field_content+'O';
    sqr1T = 1;
    turn = 1;
    vari();
    player1Check();
  }
  drawCheck();  
}

var multiplayer_spieler_zug = 1; //Zweiter Zustand f. Spieler 2 = '2'
function playGameMultiplayer(id) {
  unsetVar();
  if (multiplayer_spieler_zug === 1) {
      document.getElementById('ttt_square'+id).innerHTML = field_content+'X';
      multiplayer_spieler_zug = 2;
      player1Check();
  } else if (multiplayer_spieler_zug === 2) {
      document.getElementById('ttt_square'+id).innerHTML = field_content+'O';
      multiplayer_spieler_zug = 1;
      player2Check();
  } else {
    console.error("ERROR: Spiel nur zwischen 2 Spielern möglich bzw. ungültiger Spieler zum Zug angefordert!");
  }
}

function restartGame() {
  for (tmp of document.getElementsByClassName('ttt_square')) {
    tmp.innerHTML = field_content;
  }
}

