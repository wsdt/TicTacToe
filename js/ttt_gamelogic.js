
//if IE4/NS6, apply style
/*if (document.all||document.getElementById){
    document.write('<style>.tictac{');
    document.write('width:50px;height:50px;');
    document.write('}</style>');
}
*/
var sqr;
var spielende = false;
/*var sqr2;
var sqr3;
var sqr4;
var sqr5;
var sqr6;
var sqr7;
var sqr8;
var sqr9;*/
var sqr1T = 0;
var sqr2T = 0;
var sqr3T = 0;
var sqr4T = 0;
var sqr5T = 0;
var sqr6T = 0;
var sqr7T = 0;
var sqr8T = 0;
var sqr9T = 0;
var moveCount = 0;
var turn = 0;
var mode = 1;
var field_content = "";//'<img src="images/trans_squarefield.png" class="ttt_square_img">';

function unsetVar() {
    var sqr;
    /*var sqr2;
    var sqr3;
    var sqr4;
    var sqr5;
    var sqr6;
    var sqr7;
    var sqr8;
    var sqr9;*/
    var sqr1T = 0;
    var sqr2T = 0;
    var sqr3T = 0;
    var sqr4T = 0;
    var sqr5T = 0;
    var sqr6T = 0;
    var sqr7T = 0;
    var sqr8T = 0;
    var sqr9T = 0;
    var moveCount = 0;
    var turn = 0;
    var mode = 1;
}

/*var wait = function(){
    if(true){
        // run when condition is met
    }
    else {
        setTimeout(check, 1000); // check again in a second
    }
}*/

function vari() {
    sqr = {1:document.getElementById('ttt_square1').innerHTML,
    /*sqr[2] = {*/
    2:document.getElementById('ttt_square2').innerHTML,
    3:document.getElementById('ttt_square3').innerHTML,
    4:document.getElementById('ttt_square4').innerHTML,
    5:document.getElementById('ttt_square5').innerHTML,
    6:document.getElementById('ttt_square6').innerHTML,
    7:document.getElementById('ttt_square7').innerHTML,
    8:document.getElementById('ttt_square8').innerHTML,
    9:document.getElementById('ttt_square9').innerHTML};
}

function mark_essential_Sets(color,field1,field2,field3) { //Färbe die spielentscheidenden Spielzüge ein
    //change bg and color
    //console.log("FIELD: "+field1+","+field2+","+field3);
    var tmparr = [field1,field2,field3];
    //console.log("TMPARR: "+tmparr[0]+", "+tmparr[1]+","+tmparr[2]);
    for (var i = 0; i<3;i++) {
        //document.getElementById('ttt_square' + tmparr[i]).style.color = color; Just change the bgcolor, especially because its nicer and I would have to take a 2nd different color
        document.getElementById('ttt_square' + tmparr[i]).style.backgroundColor = color;
    }
}

function check()
{
    //console.log("startet check");

    if(sqr[1] === field_content+"X" && sqr[2] === field_content+"X" && sqr[3] === field_content+"X") {
        mark_essential_Sets('#00aa00',1,2,3);
        show_notification('#00aa00','Gratuliere, du hast das Spiel GEWONNEN!');
        reset();
    }
    else if(sqr[4] === field_content+"X" && sqr[5] === field_content+"X" && sqr[6] === field_content+"X")
    {
        mark_essential_Sets('#00aa00',4,5,6);
        show_notification('#00aa00','Gratuliere, du hast das Spiel GEWONNEN!');
        reset();
    }
    else if(sqr[7] === field_content+"X" && sqr[8] === field_content+"X" && sqr[9] === field_content+"X")
    {
        mark_essential_Sets('#00aa00',7,8,9);
        show_notification('#00aa00','Gratuliere, du hast das Spiel GEWONNEN!');
        reset();
    }
    else if(sqr[1] === field_content+"X" && sqr[5] === field_content+"X" && sqr[9] === field_content+"X")
    {
        mark_essential_Sets('#00aa00',1,5,9);
        show_notification('#00aa00','Gratuliere, du hast das Spiel GEWONNEN!');
        reset();
    }
    else if(sqr[1] === field_content+"X" && sqr[4] === field_content+"X" && sqr[7] === field_content+"X")
    {
        mark_essential_Sets('#00aa00',1,4,7);
        show_notification('#00aa00','Gratuliere, du hast das Spiel GEWONNEN!');
        reset();
    }
    else if(sqr[2] === field_content+"X" && sqr[5] === field_content+"X" && sqr[8] === field_content+"X")
    {
        mark_essential_Sets('#00aa00',2,5,8);
        show_notification('#00aa00','Gratuliere, du hast das Spiel GEWONNEN!');
        reset();
    }
    else if(sqr[3] === field_content+"X" && sqr[6] === field_content+"X" && sqr[9] === field_content+"X")
    {
        mark_essential_Sets('#00aa00',3,6,9);
        show_notification('#00aa00','Gratuliere, du hast das Spiel GEWONNEN!');
        reset();
    }
    else if(sqr[1] === field_content+"X" && sqr[5] === field_content+"X" && sqr[9] === field_content+"X")
    {
        mark_essential_Sets('#00aa00',1,5,9);
        show_notification('#00aa00','Gratuliere, du hast das Spiel GEWONNEN!');
        reset();
    }
    else if(sqr[3] === field_content+"X" && sqr[5] === field_content+"X" && sqr[7] === field_content+"X")
    {
        mark_essential_Sets('#00aa00',3,5,7);
        show_notification('#00aa00','Gratuliere, du hast das Spiel GEWONNEN!');
        reset();
    }
    else
    {
        winCheck();
        check2();
        drawCheck();
    }
}

function check2()
{
    vari();
    drawCheck();
    if(sqr[1] === field_content+"O" && sqr[2] === field_content+"O" && sqr[3] === field_content+"O")
    {
        mark_essential_Sets('#aa0000',1,2,3);
        show_notification('#aa0000','Weiter üben, du hast das Spiel VERLOREN!');
        reset();
    }
    else if(sqr[4] === field_content+"O" && sqr[5] === field_content+"O" && sqr[6] === field_content+"O")
    {
        mark_essential_Sets('#aa0000',4,5,6);
        show_notification('#aa0000','Weiter üben, du hast das Spiel VERLOREN!');
        reset();
    }
    else if(sqr[7] === field_content+"O" && sqr[8] === field_content+"O" && sqr[9] === field_content+"O")
    {
        mark_essential_Sets('#aa0000',7,8,9);
        show_notification('#aa0000','Weiter üben, du hast das Spiel VERLOREN!');
        reset();
    }
    else if(sqr[1] === field_content+"O" && sqr[5] === field_content+"O" && sqr[9] === field_content+"O")
    {
        mark_essential_Sets('#aa0000',1,5,9);
        show_notification('#aa0000','Weiter üben, du hast das Spiel VERLOREN!');
        reset();
    }
    else if(sqr[1] === field_content+"O" && sqr[4] === field_content+"O" && sqr[7] === field_content+"O")
    {
        mark_essential_Sets('#aa0000',1,4,7);
        show_notification('#aa0000','Weiter üben, du hast das Spiel VERLOREN!');
        reset();
    }
    else if(sqr[2] === field_content+"O" && sqr[5] === field_content+"O" && sqr[8] === field_content+"O")
    {
        mark_essential_Sets('#aa0000',2,5,8);
        show_notification('#aa0000','Weiter üben, du hast das Spiel VERLOREN!');
        reset();
    }
    else if(sqr[3] === field_content+"O" && sqr[6] === field_content+"O" && sqr[9] === field_content+"O")
    {
        mark_essential_Sets('#aa0000',3,6,9);
        show_notification('#aa0000','Weiter üben, du hast das Spiel VERLOREN!');
        reset();
    }
    else if(sqr[1] === field_content+"O" && sqr[5] === field_content+"O" && sqr[9] === field_content+"O")
    {
        mark_essential_Sets('#aa0000',1,5,9);
        show_notification('#aa0000','Weiter üben, du hast das Spiel VERLOREN!');
        reset();
    }
    else if(sqr[3] === field_content+"O" && sqr[5] === field_content+"O" && sqr[7] === field_content+"O")
    {
        mark_essential_Sets('#aa0000',3,5,7);
        show_notification('#aa0000','Weiter üben, du hast das Spiel VERLOREN!');
        reset();
    }
}

function player1Check()
{
    vari();
    drawCheck();

    if(sqr[1] === field_content+"X" && sqr[2] === field_content+"X" && sqr[3] === field_content+"X")
    {
        mark_essential_Sets('#0000aa',1,2,3);
        show_notification('#0000aa','Spieler 1 (= X) hat das Spiel GEWONNEN!');
        reset();
    }
    else if(sqr[4] === field_content+"X" && sqr[5] === field_content+"X" && sqr[6] === field_content+"X")
    {
        mark_essential_Sets('#0000aa',4,5,6);
        show_notification('#0000aa','Spieler 1 (= X) hat das Spiel GEWONNEN!');
        reset();
    }
    else if(sqr[7] === field_content+"X" && sqr[8] === field_content+"X" && sqr[9] === field_content+"X")
    {
        mark_essential_Sets('#0000aa',7,8,9);
        show_notification('#0000aa','Spieler 1 (= X) hat das Spiel GEWONNEN!');
        reset();
    }
    else if(sqr[1] === field_content+"X" && sqr[5] === field_content+"X" && sqr[9] === field_content+"X")
    {
        mark_essential_Sets('#0000aa',1,5,9);
        show_notification('#0000aa','Spieler 1 (= X) hat das Spiel GEWONNEN!');
        reset();
    }
    else if(sqr[1] === field_content+"X" && sqr[4] === field_content+"X" && sqr[7] === field_content+"X")
    {
        mark_essential_Sets('#0000aa',1,4,7);
        show_notification('#0000aa','Spieler 1 (= X) hat das Spiel GEWONNEN!');
        reset();
    }
    else if(sqr[2] === field_content+"X" && sqr[5] === field_content+"X" && sqr[8] === field_content+"X")
    {
        mark_essential_Sets('#0000aa',2,5,8);
        show_notification('#0000aa','Spieler 1 (= X) hat das Spiel GEWONNEN!');
        reset();
    }
    else if(sqr[3] === field_content+"X" && sqr[6] === field_content+"X" && sqr[9] === field_content+"X")
    {
        mark_essential_Sets('#0000aa',3,6,9);
        show_notification('#0000aa','Spieler 1 (= X) hat das Spiel GEWONNEN!');
        reset();
    }
    else if(sqr[1] === field_content+"X" && sqr[5] === field_content+"X" && sqr[9] === field_content+"X")
    {
        mark_essential_Sets('#0000aa',1,5,9);
        show_notification('#0000aa','Spieler 1 (= X) hat das Spiel GEWONNEN!');
        reset();
    }
    else if(sqr[3] === field_content+"X" && sqr[5] === field_content+"X" && sqr[7] === field_content+"X")
    {
        mark_essential_Sets('#0000aa',3,5,7);
        show_notification('#0000aa','Spieler 1 (= X) hat das Spiel GEWONNEN!');
        reset();
    }
    else
    {
        player2Check();
        drawCheck();
    }
}

function player2Check()
{
    vari();
    drawCheck();
    if(sqr[1] === field_content+"O" && sqr[2] === field_content+"O" && sqr[3] === field_content+"O")
    {
        mark_essential_Sets('#0000aa',1,2,3);
        show_notification('#0000aa','Spieler 2 (= O) hat das Spiel GEWONNEN!');
        reset();
    }
    else if(sqr[4] === field_content+"O" && sqr[5] === field_content+"O" && sqr[6] === field_content+"O")
    {
        mark_essential_Sets('#0000aa',4,5,6);
        show_notification('#0000aa','Spieler 2 (= O) hat das Spiel GEWONNEN!');
        reset();
    }
    else if(sqr[7] === field_content+"O" && sqr[8] === field_content+"O" && sqr[9] === field_content+"O")
    {
        mark_essential_Sets('#0000aa',7,8,9);
        show_notification('#0000aa','Spieler 2 (= O) hat das Spiel GEWONNEN!');
        reset();
    }
    else if(sqr[1] === field_content+"O" && sqr[5] === field_content+"O" && sqr[9] === field_content+"O")
    {
        mark_essential_Sets('#0000aa',1,5,9);
        show_notification('#0000aa','Spieler 2 (= O) hat das Spiel GEWONNEN!');
        reset();
    }
    else if(sqr[1] === field_content+"O" && sqr[4] === field_content+"O" && sqr[7] === field_content+"O")
    {
        mark_essential_Sets('#0000aa',1,4,7);
        show_notification('#0000aa','Spieler 2 (= O) hat das Spiel GEWONNEN!');
        reset();
    }
    else if(sqr[2] === field_content+"O" && sqr[5] === field_content+"O" && sqr[8] === field_content+"O")
    {
        mark_essential_Sets('#0000aa',2,5,8);
        show_notification('#0000aa','Spieler 2 (= O) hat das Spiel GEWONNEN!');
        reset();
    }
    else if(sqr[3] === field_content+"O" && sqr[6] === field_content+"O" && sqr[9] === field_content+"O")
    {
        mark_essential_Sets('#0000aa',3,6,9);
        show_notification('#0000aa','Spieler 2 (= O) hat das Spiel GEWONNEN!');
        reset();
    }
    else if(sqr[1] === field_content+"O" && sqr[5] === field_content+"O" && sqr[9] === field_content+"O")
    {
        mark_essential_Sets('#0000aa',1,5,9);
        show_notification('#0000aa','Spieler 2 (= O) hat das Spiel GEWONNEN!');
        reset();
    }
    else if(sqr[3] === field_content+"O" && sqr[5] === field_content+"O" && sqr[7] === field_content+"O")
    {
        mark_essential_Sets('#0000aa',3,5,7);
        show_notification('#0000aa','Spieler 2 (= O) hat das Spiel GEWONNEN!');
        reset();
    }
}

function drawCheck()
{
    vari();
    //moveCount = sqr1T + sqr2T + sqr3T + sqr4T + sqr5T + sqr6T + sqr7T + sqr8T + sqr9T;
    moveCount = 0;
    for (var i = 1; i<=9;i++) {
        if (sqr[i] !== field_content) {
            moveCount++;
        }
    }

    if(moveCount === 9)
    {
        reset();
        show_notification('#FFA500','Spiel unentschieden! (DRAW)');
    }
}

function winCheck()
{
    check2();
    if(sqr[1] === field_content+"O" && sqr[2] === field_content+"O" && sqr3T === 0 && turn === 1)
    {
        document.getElementById('ttt_square3').innerHTML = field_content+"O";
        sqr3T = 1;
        turn = 0;
    }
    else if(sqr[2] === field_content+"O" && sqr[3] === field_content+"O" && sqr1T === 0 && turn === 1)
    {
        document.getElementById('ttt_square1').innerHTML = field_content+"O";
        sqr1T = 1;
        turn = 0;
    }
    else if(sqr[4] === field_content+"O" && sqr[5] === field_content+"O" && sqr6T === 0 && turn === 1)
    {
        document.getElementById('ttt_square6').innerHTML = field_content+"O";
        sqr6T = 1;
        turn = 0;
    }
    else if(sqr[5] === field_content+"O" && sqr[6] === field_content+"O" && sqr4T === 0 && turn === 1)
    {
        document.getElementById('ttt_square4').innerHTML = field_content+"O";
        sqr4T = 1;
        turn = 0;
    }
    else if(sqr[7] === field_content+"O" && sqr[8] === field_content+"O" && sqr9T === 0 && turn === 1)
    {
        document.getElementById('ttt_square9').innerHTML = field_content+"O";
        sqr9T = 1;
        turn = 0;
    }
    else if(sqr[8] === field_content+"O" && sqr[9] === field_content+"O" && sqr7T === 0 && turn === 1)
    {
        document.getElementById('ttt_square7').innerHTML = field_content+"O";
        sqr7T = 1;
        turn = 0;
    }
    else if(sqr[1] === field_content+"O" && sqr[5] === field_content+"O" && sqr9T === 0 && turn === 1)
    {
        document.getElementById('ttt_square9').innerHTML = field_content+"O";
        sqr9T = 1;
        turn = 0;
    }
    else if(sqr[5] === field_content+"O" && sqr[9] === field_content+"O" && sqr1T === 0 && turn === 1)
    {
        document.getElementById('ttt_square1').innerHTML = field_content+"O";
        sqr1T = 1;
        turn = 0;
    }
    else if(sqr[3] === field_content+"O" && sqr[5] === field_content+"O" && sqr7T === 0 && turn === 1)
    {
        document.getElementById('ttt_square7').innerHTML = field_content+"O";
        sqr7T = 1;
        turn = 0;
    }
    else if(sqr[7] === field_content+"O" && sqr[5] === field_content+"O" && sqr3T === 0 && turn === 1)
    {
        document.getElementById('ttt_square3').innerHTML = field_content+"O";
        sqr3T = 1;
        turn = 0;
    }
    else if(sqr[1] === field_content+"O" && sqr[3] === field_content+"O" && sqr2T === 0 && turn === 1)
    {
        document.getElementById('ttt_square2').innerHTML = field_content+"O";
        sqr2T = 1;
        turn = 0;
    }
    else if(sqr[4] === field_content+"O" && sqr[6] === field_content+"O" && sqr5T === 0 && turn === 1)
    {
        document.getElementById('ttt_square5').innerHTML = field_content+"O";
        sqr5T = 1;
        turn = 0;
    }
    else if(sqr[7] === field_content+"O" && sqr[9] === field_content+"O" && sqr8T === 0 && turn === 1)
    {
        document.getElementById('ttt_square8').innerHTML = field_content+"O";
        sqr8T = 1;
        turn = 0;
    }
    else if(sqr[1] === field_content+"O" && sqr[7] === field_content+"O" && sqr4T === 0 && turn === 1)
    {
        document.getElementById('ttt_square4').innerHTML = field_content+"O";
        sqr4T = 1;
        turn = 0;
    }
    else if(sqr[2] === field_content+"O" && sqr[8] === field_content+"O" && sqr5T === 0 && turn === 1)
    {
        document.getElementById('ttt_square5').innerHTML = field_content+"O";
        sqr5T = 1;
        turn = 0;
    }
    else if(sqr[3] === field_content+"O" && sqr[9] === field_content+"O" && sqr6T === 0 && turn === 1)
    {
        document.getElementById('ttt_square6').innerHTML = field_content+"O";
        sqr6T = 1;
        turn = 0;
    }
    else if(sqr[1] === field_content+"O" && sqr[5] === field_content+"O" && sqr9T === 0 && turn === 1)
    {
        document.getElementById('ttt_square9').innerHTML = field_content+"O";
        sqr9T = 1;
        turn = 0;
    }
    else if(sqr[4] === field_content+"O" && sqr[7] === field_content+"O" && sqr1T === 0 && turn === 1)
    {
        document.getElementById('ttt_square1').innerHTML = field_content+"O";
        sqr1T = 1;
        turn = 0;
    }
    else if(sqr[5] === field_content+"O" && sqr[8] === field_content+"O" && sqr2T === 0 && turn === 1)
    {
        document.getElementById('ttt_square2').innerHTML = field_content+"O";
        sqr2T = 1;
        turn = 0;
    }
    else if(sqr[6] === field_content+"O" && sqr[9] === field_content+"O" && sqr3T === 0 && turn === 1)
    {
        document.getElementById('ttt_square3').innerHTML = field_content+"O";
        sqr3T = 1;
        turn = 0;
    }
    else if(sqr[1] === field_content+"O" && sqr[4] === field_content+"O" && sqr7T === 0 && turn === 1)
    {
        document.getElementById('ttt_square7').innerHTML = field_content+"O";
        sqr7T = 1;
        turn = 0;
    }
    else if(sqr[2] === field_content+"O" && sqr[5] === field_content+"O" && sqr8T === 0 && turn === 1)
    {
        document.getElementById('ttt_square8').innerHTML = field_content+"O";
        sqr8T = 1;
        turn = 0;
    }
    else if(sqr[3] === field_content+"O" && sqr[6] === field_content+"O" && sqr9T === 0 && turn === 1)
    {
        document.getElementById('ttt_square9').innerHTML = field_content+"O";
        sqr9T = 1;
        turn = 0;
    }
    else if(sqr[1] === field_content+"O" && sqr[9] === field_content+"O" && sqr5T === 0 && turn === 1)
    {
        document.getElementById('ttt_square5').innerHTML = field_content+"O";
        sqr5T = 1;
        turn = 0;
    }
    else if(sqr[3] === field_content+"O" && sqr[7] === field_content+"O" && sqr5T === 0 && turn === 1)
    {
        document.getElementById('ttt_square5').innerHTML = field_content+"O";
        sqr5T = 1;
        turn = 0;
    }
    else
    {
        computer();
    }
    check2();
}
function computer()
{
    check2();
    if(sqr[1] === field_content+"X" && sqr[2] === field_content+"X" && sqr3T === 0 && turn === 1)
    {
        document.getElementById('ttt_square3').innerHTML = field_content+"O";
        sqr3T = 1;
        turn = 0;
    }
    else if(sqr[2] === field_content+"X" && sqr[3] === field_content+"X" && sqr1T === 0 && turn === 1)
    {
        document.getElementById('ttt_square1').innerHTML = field_content+"O";
        sqr1T = 1;
        turn = 0;
    }
    else if(sqr[4] === field_content+"X" && sqr[5] === field_content+"X" && sqr6T === 0 && turn === 1)
    {
        document.getElementById('ttt_square6').innerHTML = field_content+"O";
        sqr6T = 1;
        turn = 0;
    }
    else if(sqr[5] === field_content+"X" && sqr[6] === field_content+"X" && sqr4T === 0 && turn === 1)
    {
        document.getElementById('ttt_square4').innerHTML = field_content+"O";
        sqr4T = 1;
        turn = 0;
    }
    else if(sqr[7] === field_content+"X" && sqr[8] === field_content+"X" && sqr9T === 0 && turn === 1)
    {
        document.getElementById('ttt_square9').innerHTML = field_content+"O";
        sqr9T = 1;
        turn = 0;
    }
    else if(sqr[8] === field_content+"X" && sqr[9] === field_content+"X" && sqr7T === 0 && turn === 1)
    {
        document.getElementById('ttt_square7').innerHTML = field_content+"O";
        sqr7T = 1;
        turn = 0;
    }
    else if(sqr[1] === field_content+"X" && sqr[5] === field_content+"X" && sqr9T === 0 && turn === 1)
    {
        document.getElementById('ttt_square9').innerHTML = field_content+"O";
        sqr9T = 1;
        turn = 0;
    }
    else if(sqr[5] === field_content+"X" && sqr[9] === field_content+"X" && sqr1T === 0 && turn === 1)
    {
        document.getElementById('ttt_square1').innerHTML = field_content+"O";
        sqr1T = 1;
        turn = 0;
    }
    else if(sqr[3] === field_content+"X" && sqr[5] === field_content+"X" && sqr7T === 0 && turn === 1)
    {
        document.getElementById('ttt_square7').innerHTML = field_content+"O";
        sqr7T = 1;
        turn = 0;
    }
    else if(sqr[7] === field_content+"X" && sqr[5] === field_content+"X" && sqr3T === 0 && turn === 1)
    {
        document.getElementById('ttt_square3').innerHTML = field_content+"O";
        sqr3T = 1;
        turn = 0;
    }
    else if(sqr[1] === field_content+"X" && sqr[3] === field_content+"X" && sqr2T === 0 && turn === 1)
    {
        document.getElementById('ttt_square2').innerHTML = field_content+"O";
        sqr2T = 1;
        turn = 0;
    }
    else if(sqr[4] === field_content+"X" && sqr[6] === field_content+"X" && sqr5T === 0 && turn === 1)
    {
        document.getElementById('ttt_square5').innerHTML = field_content+"O";
        sqr5T = 1;
        turn = 0;
    }
    else if(sqr[7] === field_content+"X" && sqr[9] === field_content+"X" && sqr8T === 0 && turn === 1)
    {
        document.getElementById('ttt_square8').innerHTML = field_content+"O";
        sqr8T = 1;
        turn = 0;
    }
    else if(sqr[1] === field_content+"X" && sqr[7] === field_content+"X" && sqr4T === 0 && turn === 1)
    {
        document.getElementById('ttt_square4').innerHTML = field_content+"O";
        sqr4T = 1;
        turn = 0;
    }
    else if(sqr[2] === field_content+"X" && sqr[8] === field_content+"X" && sqr5T === 0 && turn === 1)
    {
        document.getElementById('ttt_square5').innerHTML = field_content+"O";
        sqr5T = 1;
        turn = 0;
    }
    else if(sqr[3] === field_content+"X" && sqr[9] === field_content+"X" && sqr6T === 0 && turn === 1)
    {
        document.getElementById('ttt_square6').innerHTML = field_content+"O";
        sqr6T = 1;
        turn = 0;
    }
    else if(sqr[1] === field_content+"X" && sqr[5] === field_content+"X" && sqr9T === 0 && turn === 1)
    {
        document.getElementById('ttt_square9').innerHTML = field_content+"O";
        sqr9T = 1;
        turn = 0;
    }
    else if(sqr[4] === field_content+"X" && sqr[7] === field_content+"X" && sqr1T === 0 && turn === 1)
    {
        document.getElementById('ttt_square1').innerHTML = field_content+"O";
        sqr1T = 1;
        turn = 0;
    }
    else if(sqr[5] === field_content+"X" && sqr[8] === field_content+"X" && sqr2T === 0 && turn === 1)
    {
        document.getElementById('ttt_square2').innerHTML = field_content+"O";
        sqr2T = 1;
        turn = 0;
    }
    else if(sqr[6] === field_content+"X" && sqr[9] === field_content+"X" && sqr3T === 0 && turn === 1)
    {
        document.getElementById('ttt_square3').innerHTML = field_content+"O";
        sqr3T = 1;
        turn = 0;
    }
    else if(sqr[1] === field_content+"X" && sqr[4] === field_content+"X" && sqr7T === 0 && turn === 1)
    {
        document.getElementById('ttt_square7').innerHTML = field_content+"O";
        sqr7T = 1;
        turn = 0;
    }
    else if(sqr[2] === field_content+"X" && sqr[5] === field_content+"X" && sqr8T === 0 && turn === 1)
    {
        document.getElementById('ttt_square8').innerHTML = field_content+"O";
        sqr8T = 1;
        turn = 0;
    }
    else if(sqr[3] === field_content+"X" && sqr[6] === field_content+"X" && sqr9T === 0 && turn === 1)
    {
        document.getElementById('ttt_square9').innerHTML = field_content+"O";
        sqr9T = 1;
        turn = 0;
    }
    else if(sqr[1] === field_content+"X" && sqr[9] === field_content+"X" && sqr5T === 0 && turn === 1)
    {
        document.getElementById('ttt_square5').innerHTML = field_content+"O";
        sqr5T = 1;
        turn = 0;
    }
    else if(sqr[3] === field_content+"X" && sqr[7] === field_content+"X" && sqr5T === 0 && turn === 1)
    {
        document.getElementById('ttt_square5').innerHTML = field_content+"O";
        sqr5T = 1;
        turn = 0;
    }
    else
    {
        AI();
    }
    check2();
}

function AI()
{
    vari();
    if(document.getElementById('ttt_square5').innerHTML === field_content && turn === 1)
    {
        document.getElementById('ttt_square5').innerHTML = field_content+"O";
        turn = 0;
        sqr5T = 1;
    }
    else if( document.getElementById('ttt_square1').innerHTML === field_content && turn === 1)
    {
        document.getElementById('ttt_square1').innerHTML = field_content+"O";
        turn = 0;
        sqr1T = 1;
    }
    else if( document.getElementById('ttt_square9').innerHTML === field_content && turn === 1)
    {
        document.getElementById('ttt_square9').innerHTML = field_content+"O";
        turn = 0;
        sqr9T = 1;
    }
    else if( document.getElementById('ttt_square6').innerHTML === field_content && turn === 1)
    {
        document.getElementById('ttt_square6').innerHTML = field_content+"O";
        turn = 0;
        sqr6T = 1;
    }
    else if( document.getElementById('ttt_square2').innerHTML === field_content && turn === 1)
    {
        document.getElementById('ttt_square2').innerHTML = field_content+"O";
        turn = 0;
        sqr2T = 1;
    }
    else if( document.getElementById('ttt_square8').innerHTML === field_content && turn === 1)
    {
        document.getElementById('ttt_square8').innerHTML = field_content+"O";
        turn = 0;
        sqr8T = 1;
    }
    else if( document.getElementById('ttt_square3').innerHTML === field_content && turn === 1)
    {
        document.getElementById('ttt_square3').innerHTML = field_content+"O";
        turn = 0;
        sqr3T = 1;
    }
    else if( document.getElementById('ttt_square7').innerHTML === field_content && turn === 1)
    {
        document.getElementById('ttt_square7').innerHTML = field_content+"O";
        turn = 0;
        sqr7T = 1;
    }
    else if( document.getElementById('ttt_square4').innerHTML === field_content && turn === 1)
    {
        document.getElementById('ttt_square4').innerHTML = field_content+"O";
        turn = 0;
        sqr4T = 1;
    }
    check2();
}

function reset()
{
    spielende = true; //Für Spielzüge nach Spiel zum Blockieren
    multiplayer_spieler_zug = 1; //Standard, dass Spieler 1 anfängt (= X)
    /*
    AUSKOMMENTIERT, da entscheidender Spielzug noch zu sehen sein soll
    document.getElementById('ttt_square1').innerHTML = field_content;
    document.getElementById('ttt_square2').innerHTML  = field_content;
    document.getElementById('ttt_square3').innerHTML  = field_content;
    document.getElementById('ttt_square4').innerHTML  = field_content;
    document.getElementById('ttt_square5').innerHTML  = field_content;
    document.getElementById('ttt_square6').innerHTML  = field_content;
    document.getElementById('ttt_square7').innerHTML  = field_content;
    document.getElementById('ttt_square8').innerHTML  = field_content;
    document.getElementById('ttt_square9').innerHTML  = field_content;*/
    sqr1T = 0;
    sqr2T = 0;
    sqr3T = 0;
    sqr5T = 0;
    sqr6T = 0;
    sqr7T = 0;
    sqr8T = 0;
    sqr9T = 0;
    vari();
    turn = 0;
    moveCount = 0;
}

function resetter()
{
    reset();
}

/*
<FORM NAME="tic" method="post">
    <INPUT TYPE="button" NAME="sqr1" class="tictac" innerHTML=field_content onClick="if(document.tic.sqr1.innerHTML === '     ' && turn === 0 && mode === 1) {document.tic.sqr1.innerHTML = ' X '; sqr1T = 1; turn = 1; vari(); check();} else if(document.tic.sqr1.innerHTML === '     ' && turn === 1 && mode === 2) {document.tic.sqr1.innerHTML = ' X '; sqr1T = 1; turn = 0; vari(); player1Check()} else if(document.tic.sqr1.innerHTML === '     ' && turn === 0 && mode === 2) {document.tic.sqr1.innerHTML = ' O '; sqr1T = 1; turn = 1; vari(); player1Check()} drawCheck()">
    <INPUT TYPE="button" NAME="sqr2" class="tictac" innerHTML=field_content onClick="if(document.tic.sqr2.innerHTML === '     ' && turn === 0 && mode === 1) {document.tic.sqr2.innerHTML = ' X '; sqr2T = 1; turn = 1; vari(); check();} else if(document.tic.sqr2.innerHTML === '     ' && turn === 1 && mode === 2) {document.tic.sqr2.innerHTML = ' X '; sqr2T = 1; turn = 0; vari(); player1Check()} else if(document.tic.sqr2.innerHTML === '     ' && turn === 0 && mode === 2) {document.tic.sqr2.innerHTML = ' O '; sqr2T = 1; turn = 1; vari(); player1Check()} drawCheck()">
    <INPUT TYPE="button" NAME="sqr3" class="tictac" innerHTML=field_content onClick="if(document.tic.sqr3.innerHTML === '     ' && turn === 0 && mode === 1) {document.tic.sqr3.innerHTML = ' X '; sqr3T = 1; turn = 1; vari(); check();} else if(document.tic.sqr3.innerHTML === '     ' && turn === 1 && mode === 2) {document.tic.sqr3.innerHTML = ' X '; sqr3T = 1; turn = 0; vari(); player1Check()} else if(document.tic.sqr3.innerHTML === '     ' && turn === 0 && mode === 2) {document.tic.sqr3.innerHTML = ' O '; sqr3T = 1; turn = 1; vari(); player1Check()} drawCheck()"><br />
    <INPUT TYPE="button" NAME="sqr4" class="tictac" innerHTML=field_content onClick="if(document.tic.sqr4.innerHTML === '     ' && turn === 0 && mode === 1) {document.tic.sqr4.innerHTML = ' X '; sqr4T = 1; turn = 1; vari(); check();} else if(document.tic.sqr4.innerHTML === '     ' && turn === 1 && mode === 2) {document.tic.sqr4.innerHTML = ' X '; sqr4T = 1; turn = 0; vari(); player1Check()} else if(document.tic.sqr4.innerHTML === '     ' && turn === 0 && mode === 2) {document.tic.sqr4.innerHTML = ' O '; sqr4T = 1; turn = 1; vari(); player1Check()} drawCheck()">
    <INPUT TYPE="button" NAME="sqr5" class="tictac" innerHTML=field_content onClick="if(document.tic.sqr5.innerHTML === '     ' && turn === 0 && mode === 1) {document.tic.sqr5.innerHTML = ' X '; sqr5T = 1; turn = 1; vari(); check();} else if(document.tic.sqr5.innerHTML === '     ' && turn === 1 && mode === 2) {document.tic.sqr5.innerHTML = ' X '; sqr5T = 1; turn = 0; vari(); player1Check()} else if(document.tic.sqr5.innerHTML === '     ' && turn === 0 && mode === 2) {document.tic.sqr5.innerHTML = ' O '; sqr5T = 1; turn = 1; vari(); player1Check()} drawCheck()">
    <INPUT TYPE="button" NAME="sqr6" class="tictac" innerHTML=field_content onClick="if(document.tic.sqr6.innerHTML === '     ' && turn === 0 && mode === 1) {document.tic.sqr6.innerHTML = ' X '; sqr6T = 1; turn = 1; vari(); check();} else if(document.tic.sqr6.innerHTML === '     ' && turn === 1 && mode === 2) {document.tic.sqr6.innerHTML = ' X '; sqr6T = 1; turn = 0; vari(); player1Check()} else if(document.tic.sqr6.innerHTML === '     ' && turn === 0 && mode === 2) {document.tic.sqr6.innerHTML = ' O '; sqr6T = 1; turn = 1; vari(); player1Check()} drawCheck()"><br />
    <INPUT TYPE="button" NAME="sqr7" class="tictac" innerHTML=field_content onClick="if(document.tic.sqr7.innerHTML === '     ' && turn === 0 && mode === 1) {document.tic.sqr7.innerHTML = ' X '; sqr7T = 1; turn = 1; vari(); check();} else if(document.tic.sqr7.innerHTML === '     ' && turn === 1 && mode === 2) {document.tic.sqr7.innerHTML = ' X '; sqr7T = 1; turn = 0; vari(); player1Check()} else if(document.tic.sqr7.innerHTML === '     ' && turn === 0 && mode === 2) {document.tic.sqr7.innerHTML = ' O '; sqr7T = 1; turn = 1; vari(); player1Check()} drawCheck()">
    <INPUT TYPE="button" NAME="sqr8" class="tictac" innerHTML=field_content onClick="if(document.tic.sqr8.innerHTML === '     ' && turn === 0 && mode === 1) {document.tic.sqr8.innerHTML = ' X '; sqr8T = 1; turn = 1; vari(); check();} else if(document.tic.sqr8.innerHTML === '     ' && turn === 1 && mode === 2) {document.tic.sqr8.innerHTML = ' X '; sqr8T = 1; turn = 0; vari(); player1Check()} else if(document.tic.sqr8.innerHTML === '     ' && turn === 0 && mode === 2) {document.tic.sqr8.innerHTML = ' O '; sqr8T = 1; turn = 1; vari(); player1Check()} drawCheck()">
    <INPUT TYPE="button" NAME="sqr9" class="tictac" innerHTML=field_content onClick="if(document.tic.sqr9.innerHTML === '     ' && turn === 0 && mode === 1) {document.tic.sqr9.innerHTML = ' X '; sqr9T = 1; turn = 1; vari(); check();} else if(document.tic.sqr9.innerHTML === '     ' && turn === 1 && mode === 2) {document.tic.sqr9.innerHTML = ' X '; sqr9T = 1; turn = 0; vari(); player1Check()} else if(document.tic.sqr9.innerHTML === '     ' && turn === 0 && mode === 2) {document.tic.sqr9.innerHTML = ' O '; sqr9T = 1; turn = 1; vari(); player1Check()} drawCheck()">
    </form>
*/

