// Lightbox
function closebox() {
  document.getElementById('overlayLogin').style.display = "none";
  document.getElementById('overlay').style.display = "none";
}

// NOTIFICATIONS -----------------------------------------------------------------------------------
//Close Notification
function close_notification() {
    var not_bar = document.getElementById('notification');
  //document.getElementById('notification').className = ""; //Because notification is an Id
    not_bar.style.top = '-23px';
}

function show_notification(bgcolor, text) {
  if (bgcolor === '#fff' || bgcolor === '#ffffff' || bgcolor === 'black') {
    console.warn("WARNING: You won't see your text with that background-color!");
  }
  var not_bar = document.getElementById('notification');
  //not_bar.className = "notification_active";
  not_bar.style.top = 0;
  document.getElementById('notification_text').innerHTML = text;
  not_bar.style.backgroundColor = bgcolor;
}

// -------------------------------------------------------------------------------------------------
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
  close_notification();

  //wenn ein Feld in Farbe = Spiel zu Ende, dann tue nichts oder gib Meldung aus. Bei Draw unnötig, da ohnehin alle Felder besetzt
  /*for (var tmp of document.getElementsByClassName('ttt_square')) {
    console.log(tmp);
    if (tmp.style.backgroundColor !== '#444' && tmp.style.backgroundColor !== '#aaa') {
      spielzug_erlaubt = false;
      show_notification('#000', 'Spiel bereits zu Ende!');
      break;
    }
  }*/
  if (spielende) {
    show_notification('#000','Spiel bereits zu Ende!');
  } else {
      var modus = 1;
      if (document.getElementById('bt_singleplayer').className === "btn btn-primary") {
          modus = 0;
          playGameSingleplayer(id);
      } else {
          playGameMultiplayer(id);
      }
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
  var curr_field = document.getElementById('ttt_square'+id);
  if (multiplayer_spieler_zug === 1) {
      if (curr_field.innerHTML === field_content) {
          curr_field.innerHTML = field_content + 'X';
          multiplayer_spieler_zug = 2;
          player1Check();
      } else {
        show_notification('#000','Dieses Feld wurde bereits ausgewählt!');
      }
  } else if (multiplayer_spieler_zug === 2) {
      if (curr_field.innerHTML === field_content) {
          curr_field.innerHTML = field_content + 'O';
          multiplayer_spieler_zug = 1;
          player2Check();
      } else {
          show_notification('#000','Dieses Feld wurde bereits ausgewählt!');
      }
  } else {
    console.error("ERROR: Spiel nur zwischen 2 Spielern möglich bzw. ungültiger Spieler zum Zug angefordert!");
  }
}

function uncolor_essential_fields() { //Wenn Spiel zu Ende werden entscheidende Spielzüge eingefärbt, hier werden sie entfärbt
  for (tmp of document.getElementsByClassName('ttt_square')) {
    tmp.style.backgroundColor = '#444';
  }
}

function restartGame() {
  for (tmp of document.getElementsByClassName('ttt_square')) {
    tmp.innerHTML = field_content; //empty all fields
  }
  document.getElementById('notification').style.top = '-23px'; //hide notification bar
  uncolor_essential_fields();
  spielende = false; //Sagen, dass Spiel neu angefangen
}

