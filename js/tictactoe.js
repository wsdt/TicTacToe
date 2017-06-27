// NOTIFICATIONS -----------------------------------------------------------------------------------
//Close Notification
function close_notification() {
    var not_bar = document.getElementById('notification');
    not_bar.style.top = '-23px'; //Verschiebe Bar nach oben womit diese nicht mehr sichtbar ist. 
}

function show_notification(bgcolor, text) {
    document.getElementById('notification_text').style.color = '#fff'; //Make textcolor white by default
  if (bgcolor === '#fff' || bgcolor === '#ffffff' || bgcolor === 'black') {
    console.warn("INFO: We changed the font color for you to black, so you can read it.");
    document.getElementById('notification_text').style.color = '#000';
  }
  var not_bar = document.getElementById('notification');
  not_bar.style.top = 0;
  document.getElementById('notification_text').innerHTML = text;
  not_bar.style.backgroundColor = bgcolor;
}

// -------------------------------------------------------------------------------------------------
//Start-Game
function changeMode(modus) { //Change Button-Styles according to active mode etc. 
  console.log("Try to change Gamemode; Mode: "+modus); //0 = Single Player ; 1 = Multiplayer
  if (modus === 0) {
    document.getElementById('bt_singleplayer').className = "btn btn-primary"; //Active and Deactivate Button (Style)
    document.getElementById('bt_multiplayer').className = "btn btn-default";
    document.getElementById('bt_difficulty').style.display = "inline-block";
    restartGame();
  } else if (modus === 1) {
    document.getElementById('bt_singleplayer').className = "btn btn-default";
    document.getElementById('bt_multiplayer').className = "btn btn-primary";
    document.getElementById('bt_difficulty').style.display = "none";
    restartGame();
  } else {
    document.getElementById('bt_singleplayer').className = "btn btn-default";
    document.getElementById('bt_multiplayer').className = "btn btn-default";
    console.error("Game Mode NOT FOUND!");
    restartGame();
  }
}

function setZug(id) { //Wird aufgerufen, sobald auf ein TTT-Feld geklickt wird. 
  close_notification();

  if (spielende) { //Spiel vorbei? 
    show_notification('#000','Spiel bereits zu Ende!');
  } else {
      if (document.getElementById('bt_singleplayer').className === "btn btn-primary") { //Wenn Singleplayer
          playGameSingleplayer(id);
      } else {
          playGameMultiplayer(id);
      }
  }
}

function playGameSingleplayer(id) {
  //Turn 0 = User dran ; Turn 1 = PC dran
  if(document.getElementById('ttt_square'+id).innerHTML === field_content && turn === 0) {
    document.getElementById('ttt_square'+id).innerHTML = field_content+'X';
    turn = 1;
    check(0,"X");
  }//IMPORTANT: You need here a normal if, not an else if (sonst erfolgt PC-Zug nicht automatisch)
  if(turn === 1) {
    turn = 0;
    var difficulty = "easy";
    if (document.getElementById('bt_difficulty').className === "btn btn-danger") {
        difficulty = "impossible";
    }
    computerTurn(difficulty); //solange nicht difficulty==impossible wird wahllos gesetzt
    //check(0,"O"); is checked in computerTurn()
  }
}

//Außerhalb der Funktion definiert, damit nicht immer bei Funktionsaufruf gesetzt
var multiplayer_spieler_zug = 1; //Zweiter Zustand f. Spieler 2 = '2'
function playGameMultiplayer(id) {
  var curr_field = document.getElementById('ttt_square'+id);
  if (multiplayer_spieler_zug === 1) {
      if (curr_field.innerHTML === field_content) {
          curr_field.innerHTML = field_content + 'X';
          multiplayer_spieler_zug = 2;
          //player1Check();
          check(1,'X'); //Prüfe ob gewonnen oder draw
      } else {
        show_notification('#000','Dieses Feld wurde bereits ausgewählt!');
      }
  } else if (multiplayer_spieler_zug === 2) {
      if (curr_field.innerHTML === field_content) {
          curr_field.innerHTML = field_content + 'O';
          multiplayer_spieler_zug = 1;
          check(1,'O'); //Prüfe ob gewonnen oder draw
      } else {
          show_notification('#000','Dieses Feld wurde bereits ausgewählt!');
      }
  } else {
    console.error("ERROR: Spiel nur zwischen 2 Spielern möglich bzw. ungültiger Spieler zum Zug angefordert!");
  }
}

function uncolor_essential_fields() { //Wenn Spiel zu Ende werden entscheidende Spielzüge eingefärbt, hier werden sie entfärbt
  //Gelöster Hover-Bug v. Max: 
  for (tmp of document.getElementsByClassName('ttt_square')) {
    $(tmp).css("background-color","");
	//tmp.style.backgroundColor = '#444';
  }
}

function changeDifficulty() {
    restartGame();

	//(De)Aktiviere Impossible-Mode
    var tmpelement = document.getElementById('bt_difficulty');
    if (tmpelement.className === "btn btn-danger") {
        tmpelement.className = "btn btn-default";
        show_notification('#FF0080','IMPOSSIBLE-Mode deaktiviert!');
    } else {
        tmpelement.className = "btn btn-danger";
        show_notification('#FF0080','IMPOSSIBLE-Mode aktiviert!');
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

