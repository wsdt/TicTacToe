var sqr;
var spielende = false;
var moveCount = 0;
var turn = 0;
//Field-Content, wenn etwas innerhalb der TTT-Felder sein sollte (z.B. ein Bild für responsive Höhenanpassung etc.)
var field_content = ""; //'<img src="images/trans_squarefield.png" class="ttt_square_img">';

//Aktualisiere bzw. definiere Inhalt der TTT-Felder neu
function vari() {
    sqr = { //Erstelle Objekt
        1: document.getElementById('ttt_square1').innerHTML,
        /*sqr[2] = {*/
        2: document.getElementById('ttt_square2').innerHTML,
        3: document.getElementById('ttt_square3').innerHTML,
        4: document.getElementById('ttt_square4').innerHTML,
        5: document.getElementById('ttt_square5').innerHTML,
        6: document.getElementById('ttt_square6').innerHTML,
        7: document.getElementById('ttt_square7').innerHTML,
        8: document.getElementById('ttt_square8').innerHTML,
        9: document.getElementById('ttt_square9').innerHTML
    };
}

//Färbe nach Ende des Spieles die entscheidenden Felder ein (blau = Mehrspieler, grün = Einspieler gewonnen, rot = Einspieler verloren)
function mark_essential_Sets(color, field1, field2, field3) { //Färbe die spielentscheidenden Spielzüge ein
    var tmparr = [field1, field2, field3];
    for (var i = 0; i < 3; i++) {
        //document.getElementById('ttt_square' + tmparr[i]).style.color = color; Just change the bgcolor, especially because its nicer and I would have to take a 2nd different color
        document.getElementById('ttt_square' + tmparr[i]).style.backgroundColor = color;
    }
}

function check(gameType, setType) { // setType = 'X' || 'O' ***** gameType = '0' || '1' (0 = Singleplayer, 1 = Multiplayer)
    vari(); //Aktualisiere Inhalt der Felder (wo ist was gesetzt worden)
    var color = "#000";
    var message = "ERROR: Could not define correct message";
    var setType_tmp = "";

    //Define vars for database 'save Highscore'
    var new_wins = 0;
    var new_draws = 0;
    var new_losses = 0;
    var add_to = ""; //possible values: 'wins', 'draws', 'losses' --> wins++ etc.

    if (gameType === 0) { //If Singleplayer (=0)
        if (setType === "X") {
            color = "#00aa00";
            message = "Gratuliere, du hast das Spiel GEWONNEN!";
            add_to = "wins"; //Im Einzelspielermodus gewonnen
        } //Set Color won for singleplayer
        else {
            color = "#aa0000";
            message = "Weiter üben, du hast das Spiel VERLOREN!";
            add_to = "losses"; //Im Einzelspielermodus verloren
        } //set color lost for singleplayer
    } else {
        color = "#0000aa"; //if multiplayer set color blue, because player 1 or player to can win
        setType_tmp = setType.toString().toUpperCase();
        message = "Spieler '" + setType_tmp + "' hat das Spiel GEWONNEN!";
        if (setType_tmp === "X") {
            add_to = "wins"; //Gegen Gastspieler im Mehrspielermodus gewonnen
        } else {
            add_to = "losses"; //Gegen Gastspieler (Mehrspielermodus) verloren
        }

    }

    if (sqr[1] === field_content + setType && sqr[2] === field_content + setType && sqr[3] === field_content + setType) {
        if (add_to === "wins") {
            new_wins++; //Sage, dass einmal mehr gewonnen
        } else {
            new_losses++;
        }
        GameOver(color, 1, 2, 3, message, new_wins, new_draws, new_losses);
    }
    else if (sqr[4] === field_content + setType && sqr[5] === field_content + setType && sqr[6] === field_content + setType) {
        if (add_to === "wins") {
            new_wins++; //Sage, dass einmal mehr gewonnen
        } else {
            new_losses++;
        }
        GameOver(color, 4, 5, 6, message, new_wins, new_draws, new_losses);
    }
    else if (sqr[7] === field_content + setType && sqr[8] === field_content + setType && sqr[9] === field_content + "X") {
        if (add_to === "wins") {
            new_wins++; //Sage, dass einmal mehr gewonnen
        } else {
            new_losses++;
        }
        GameOver(color, 7, 8, 9, message, new_wins, new_draws, new_losses);
    }
    else if (sqr[1] === field_content + setType && sqr[4] === field_content + setType && sqr[7] === field_content + setType) {
        if (add_to === "wins") {
            new_wins++; //Sage, dass einmal mehr gewonnen
        } else {
            new_losses++;
        }
        GameOver(color, 1, 4, 7, message, new_wins, new_draws, new_losses);
    }
    else if (sqr[2] === field_content + setType && sqr[5] === field_content + setType && sqr[8] === field_content + setType) {
        if (add_to === "wins") {
            new_wins++; //Sage, dass einmal mehr gewonnen
        } else {
            new_losses++;
        }
        GameOver(color, 2, 5, 8, message, new_wins, new_draws, new_losses);
    }
    else if (sqr[3] === field_content + setType && sqr[6] === field_content + setType && sqr[9] === field_content + setType) {
        if (add_to === "wins") {
            new_wins++; //Sage, dass einmal mehr gewonnen
        } else {
            new_losses++;
        }
        GameOver(color, 3, 6, 9, message, new_wins, new_draws, new_losses);
    }
    else if (sqr[1] === field_content + setType && sqr[5] === field_content + setType && sqr[9] === field_content + setType) {
        if (add_to === "wins") {
            new_wins++; //Sage, dass einmal mehr gewonnen
        } else {
            new_losses++;
        }
        GameOver(color, 1, 5, 9, message, new_wins, new_draws, new_losses);
    }
    else if (sqr[3] === field_content + setType && sqr[5] === field_content + setType && sqr[7] === field_content + setType) {
        if (add_to === "wins") {
            new_wins++; //Sage, dass einmal mehr gewonnen
        } else {
            new_losses++;
        }
        GameOver(color, 3, 5, 7, message, new_wins, new_draws, new_losses);
    }
    else {
        add_to = drawCheck(); //Prüfe ob Draw, wenn ja speichere 'draws' in add_to
        if (add_to === "draws") {
            new_draws++;
            save_Game(new_wins, new_draws, new_losses);
        }
    }
}

function GameOver(color, field1, field2, field3, message, new_wins, new_draws, new_losses) {
    console.log("In Game over: ");
    console.log("w: "+new_wins+";d:"+new_draws+";l:"+new_losses);
    mark_essential_Sets(color, field1, field2, field3); //Färbe Felder ein
    show_notification(color, message); //Message = Message to show in notification bar

    save_Game(new_wins, new_draws, new_losses); //Werte ermitteln und übergeben
    reset(); //Resette Spiel
}

function save_Game(win_count, draws_count, losses_count) {

    $.ajax({
        url: "php/highscore_save.php",
        method: "post",
        //Übergib Werte aus aktuellem Spiel!
        data: {
            username: document.getElementById('label_username').innerHTML,
            wins: win_count,
            draws: draws_count,
            losses: losses_count
        },
        success: function (receivedData) {
            if (receivedData.indexOf("SUCCESS") <= (-1) || receivedData.indexOf("FAIL") >= (0)) { //Wenn Schlüsselwort SUCCESS vorhanden, aber kein FAIL (= echo Statements in aufgerufenen Funktionen)
                show_notification('#ff0000', 'AJAX_Error: Ihr Highscore konnte nicht in unsere Datenbank übertragen werden!');
                console.error("Received Data: "+receivedData);
            } else {
                console.log(receivedData);
            }
        }
    });
}

function drawCheck() {
    vari();
    //moveCount = sqr1T + sqr2T + sqr3T + sqr4T + sqr5T + sqr6T + sqr7T + sqr8T + sqr9T;
    moveCount = 0;
    for (var i = 1; i <= 9; i++) {
        if (sqr[i] !== field_content) {
            moveCount++;
        }
    }

    if (moveCount === 9) { //Prüfe ob alle Felder besetzt. Wird ohnehin nur ausgeführt wenn niemand gewonnen/verloren hat
        reset();
        show_notification('#FFA500', 'Spiel unentschieden! (DRAW)');
        return "draws"; //Gib draws zurück, damit andere Methoden über Ausgang des Spiels Bescheid wissen
    }
}

function pruefeFeldFrei(id) { //Darf auf übergebenen Feld gesetzt werden?
    if (document.getElementById(id).innerHTML === field_content) {
        return true;
    }
    return false;
}

function computerTurn(difficulty) {
    var didIsetSth = false;
    vari();

    /*
     Reihenfolge wichtig wie in Array gespeichert, damit zuerst kontrolliert wird, mit welchem Zug gewonnen werden kann,
     bzw. wenn keiner möglich ist, mit welchem Zug er den Sieg des Gegners vereiteln kann. Sonst setze zufällig.
     */

    if (difficulty === "impossible") { //Geht hier nur rein, wenn Totenkopf-Button angeklickt wurde
        var players = ["O", "X"]; //Da 'O' zuerst, wird zuerst geprüft wie er setzen muss, um zu gewinnen. Danach bei Misserfolg prüft er wo er einen Sieg des Users verhindern kann
        for (var player of players) { //für X und O
            if (sqr[1] === field_content + player && sqr[2] === field_content + player && pruefeFeldFrei('ttt_square3')) {
                document.getElementById('ttt_square3').innerHTML = field_content + "O";
                didIsetSth = true; //Important for random allocation !
                break;
            }
            else if (sqr[2] === field_content + player && sqr[3] === field_content + player && pruefeFeldFrei('ttt_square1')) {
                document.getElementById('ttt_square1').innerHTML = field_content + "O";
                didIsetSth = true; //Important for random allocation !
                break;
            }
            else if (sqr[1] === field_content + player && sqr[3] === field_content + player && pruefeFeldFrei('ttt_square2')) {
                document.getElementById('ttt_square2').innerHTML = field_content + "O";
                didIsetSth = true; //Important for random allocation !
                break;
            }
            else if (sqr[4] === field_content + player && sqr[5] === field_content + player && pruefeFeldFrei('ttt_square6')) {
                document.getElementById('ttt_square6').innerHTML = field_content + "O";
                didIsetSth = true; //Important for random allocation !
                break;
            }
            else if (sqr[5] === field_content + player && sqr[6] === field_content + player && pruefeFeldFrei('ttt_square4')) {
                document.getElementById('ttt_square4').innerHTML = field_content + "O";
                didIsetSth = true; //Important for random allocation !
                break;
            }
            else if (sqr[4] === field_content + player && sqr[6] === field_content + player && pruefeFeldFrei('ttt_square5')) {
                document.getElementById('ttt_square5').innerHTML = field_content + "O";
                didIsetSth = true; //Important for random allocation !
                break;
            }
            else if (sqr[7] === field_content + player && sqr[8] === field_content + player && pruefeFeldFrei('ttt_square9')) {
                document.getElementById('ttt_square9').innerHTML = field_content + "O";
                didIsetSth = true; //Important for random allocation !
                break;
            }
            else if (sqr[8] === field_content + player && sqr[9] === field_content + player && pruefeFeldFrei('ttt_square7')) {
                document.getElementById('ttt_square7').innerHTML = field_content + "O";
                didIsetSth = true; //Important for random allocation !
                break;
            }
            else if (sqr[7] === field_content + player && sqr[9] === field_content + player && pruefeFeldFrei('ttt_square8')) {
                document.getElementById('ttt_square8').innerHTML = field_content + "O";
                didIsetSth = true; //Important for random allocation !
                break;
            }
            else if (sqr[1] === field_content + player && sqr[5] === field_content + player && pruefeFeldFrei('ttt_square9')) {
                document.getElementById('ttt_square9').innerHTML = field_content + "O";
                didIsetSth = true; //Important for random allocation !
                break;
            }
            else if (sqr[5] === field_content + player && sqr[9] === field_content + player && pruefeFeldFrei('ttt_square1')) {
                document.getElementById('ttt_square1').innerHTML = field_content + "O";
                didIsetSth = true; //Important for random allocation !
                break;
            }
            else if (sqr[1] === field_content + player && sqr[9] === field_content + player && pruefeFeldFrei('ttt_square5')) {
                document.getElementById('ttt_square5').innerHTML = field_content + "O";
                didIsetSth = true; //Important for random allocation !
                break;
            }
            else if (sqr[3] === field_content + player && sqr[5] === field_content + player && pruefeFeldFrei('ttt_square7')) {
                document.getElementById('ttt_square7').innerHTML = field_content + "O";
                didIsetSth = true; //Important for random allocation !
                break;
            }
            else if (sqr[7] === field_content + player && sqr[5] === field_content + player && pruefeFeldFrei('ttt_square3')) {
                document.getElementById('ttt_square3').innerHTML = field_content + "O";
                didIsetSth = true; //Important for random allocation !
                break;
            }
            else if (sqr[7] === field_content + player && sqr[3] === field_content + player && pruefeFeldFrei('ttt_square5')) {
                document.getElementById('ttt_square5').innerHTML = field_content + "O";
                didIsetSth = true; //Important for random allocation !
                break;
            }
            else if (sqr[1] === field_content + player && sqr[4] === field_content + player && pruefeFeldFrei('ttt_square7')) {
                document.getElementById('ttt_square7').innerHTML = field_content + "O";
                didIsetSth = true; //Important for random allocation !
                break;
            }
            else if (sqr[1] === field_content + player && sqr[7] === field_content + player && pruefeFeldFrei('ttt_square4')) {
                document.getElementById('ttt_square4').innerHTML = field_content + "O";
                didIsetSth = true; //Important for random allocation !
                break;
            }
            else if (sqr[4] === field_content + player && sqr[7] === field_content + player && pruefeFeldFrei('ttt_square1')) {
                document.getElementById('ttt_square1').innerHTML = field_content + "O";
                didIsetSth = true; //Important for random allocation !
                break;
            }
            else if (sqr[2] === field_content + player && sqr[5] === field_content + player && pruefeFeldFrei('ttt_square8')) {
                document.getElementById('ttt_square8').innerHTML = field_content + "O";
                didIsetSth = true; //Important for random allocation !
                break;
            }
            else if (sqr[2] === field_content + player && sqr[8] === field_content + player && pruefeFeldFrei('ttt_square5')) {
                document.getElementById('ttt_square5').innerHTML = field_content + "O";
                didIsetSth = true; //Important for random allocation !
                break;
            }
            else if (sqr[5] === field_content + player && sqr[8] === field_content + player && pruefeFeldFrei('ttt_square2')) {
                document.getElementById('ttt_square2').innerHTML = field_content + "O";
                didIsetSth = true; //Important for random allocation !
                break;
            }
            else if (sqr[3] === field_content + player && sqr[6] === field_content + player && pruefeFeldFrei('ttt_square9')) {
                document.getElementById('ttt_square9').innerHTML = field_content + "O";
                didIsetSth = true; //Important for random allocation !
                break;
            }
            else if (sqr[3] === field_content + player && sqr[9] === field_content + player && pruefeFeldFrei('ttt_square6')) {
                document.getElementById('ttt_square6').innerHTML = field_content + "O";
                didIsetSth = true; //Important for random allocation !
                break;
            }
            else if (sqr[6] === field_content + player && sqr[9] === field_content + player && pruefeFeldFrei('ttt_square3')) {
                document.getElementById('ttt_square3').innerHTML = field_content + "O";
                didIsetSth = true; //Important for random allocation !
                break;
            }
        }
    }

    //Setze Felder nach Zufallsprinzip
    if (!didIsetSth) { //Wenn Computer noch nichts gesetzt hat, dann setze freies Feld durch Zufall.
        var freieFelder = new Array();
        var alleFelder = [
            document.getElementById('ttt_square1'),
            document.getElementById('ttt_square2'),
            document.getElementById('ttt_square3'),
            document.getElementById('ttt_square4'),
            document.getElementById('ttt_square5'),
            document.getElementById('ttt_square6'),
            document.getElementById('ttt_square7'),
            document.getElementById('ttt_square8'),
            document.getElementById('ttt_square9')
        ];
        var j = 0; //index array = 0
        for (var field of alleFelder) {
            if (field.innerHTML === field_content) {
                freieFelder[j++] = field.id; //set array from 0 with all index values of sqr which are not set yet
            }
        }
        var randomField = Math.floor(Math.random() * (freieFelder.length - 1))/* + 0*/; //wähle zufälliges Feld aus freien Feldern

        document.getElementById(freieFelder[randomField]).innerHTML = field_content + "O";
    }

    check(0, "O");
}

function reset() {
    spielende = true; //Für Spielzüge nach Spiel zum Blockieren
    multiplayer_spieler_zug = 1; //Standard, dass Spieler 1 anfängt (= X) Könnte hier sonst umgestellt werden

    vari();
    turn = 0;
    moveCount = 0;
}





