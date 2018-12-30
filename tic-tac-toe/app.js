
// turn will equal X, O

var isTie = false, turn = 'X', player1 = '?', player2 = '?', plays = 0,

squares = ['', '', '', '', '', '', '', '', ''];

function clickedX(){
	player1 = 'X';
	player2 = 'O';
	turn = 'X';
	squares = ['', '', '', '', '', '', '', '', ''];
	startGame();
	drawgame(player1, player2, squares);
}

function clickedO(){
	player1 = 'O';
	player2 = 'X';
	turn = 'O';
	squares = ['', '', '', '', '', '', '', '', ''];
	startGame();
	drawgame(player1, player2, squares);
}

function drawgame (firstPlayer, secondPlayer, squares){ // params are player objects and an array of square objects
		
	if (isWon(player1)){
		document.getElementById('player-two').innerHTML = player1 + ' wins!  Choose X or O to play again.';
		stopGame();
	}else{
		if (isWon(player2)){
			document.getElementById('player-two').innerHTML = player2 + ' wins!  Choose X or O to play again.';
			stopGame();
		}else{document.getElementById('player-two').innerHTML = '';}
	}
	if (isTie){
		document.getElementById('player-two').innerHTML = 'Tied game!  Choose X or O to play again.';
		stopGame();
	}else//{document.getElementById('player-two').innerHTML = '';}
	if (turn === player1){
		document.getElementById('player-one').innerHTML = firstPlayer + '\'s turn';
		}
	if (turn === player2){
		document.getElementById('player-one').innerHTML = secondPlayer + '\'s turn';
		}
	for (i = 0; i < 9; i++){
		document.getElementById(i).innerHTML = squares[i];
		if (isWon()){}
	}
}
drawgame(player1, player2, squares);

function clickSquare(square, value){
	square = turn;
	plays = plays + 1;
}

//assign onclick to each square with iffy to keep loop counter scope
startGame = function(){
isTie = false;
for (var i = 0; i < 9; i++){
	
	(function(lockedInIndex){	
		
		document.getElementById(i).addEventListener("click", function(event){
			event.preventDefault(); // prevents resize on iphone dblclick
			if ((squares[lockedInIndex] === '')&&(isWon(player1)=== false)&&(isWon(player2)=== false)&& (isTie === false)){//&& (isTie = false)
				squares[lockedInIndex] = turn;
				turn = (turn === 'X'? 'O':'X');  //toggle turn to x and o
				if (turn === player2){
					takeTurn(turn);
				}

				drawgame(player1, player2, squares);
			}
		});
	})(i);
}// end for
};//end function assignment

stopGame = function(){

for (var i = 0; i < 9; i++){
	
	(function(lockedInIndex){	
		document.getElementById(i).removeEventListener("click", function(event){
			event.preventDefault(); // prevents resize on iphone dblclick
		});
	})(i);
}// end for
};//end function assignment

function isWon(player){
	
	if (squares.indexOf('') === -1){
		isTie = true;
		}
	
	if((squares[0] === player) && (squares[1] === player) && (squares[2] === player)||
	(squares[3] === player) && (squares[4] === player) && (squares[5] === player)||
	(squares[6] === player) && (squares[7] === player) && (squares[8] === player)||
	(squares[0] === player) && (squares[3] === player) && (squares[6] === player)||
	(squares[1] === player) && (squares[4] === player) && (squares[7] === player)||
	(squares[2] === player) && (squares[5] === player) && (squares[8] === player)||
	(squares[6] === player) && (squares[4] === player) && (squares[2] === player)||
	(squares[0] === player) && (squares[4] === player) && (squares[8] === player)){
	 return true;
	}else{
		//console.log('isWon is false');
		return false;
		}
}

//deciding the machine's move goes here
function takeTurn(player){
	var machinePlayer = player, humanPlayer;
	humanPlayer = (machinePlayer === 'X'? 'O':'X');
	
	//First, try all the squares to see if any win
	for (var i = 0; i < 9; i++){
		if (squares[i] === ''){
			squares[i] = machinePlayer;
			if (isWon(machinePlayer) === true){
				turn = (turn === 'X'? 'O':'X');
				drawgame(player1, player2, squares);
				return i;
			}else {squares[i] = '';}
		}
	}//end check for winning move
	
	//Now check to see if opponent is one move away from winning
		for (var i = 0; i < 9; i++){
		if (squares[i] === ''){
			squares[i] = humanPlayer;//test if human has possible winning move
			if (isWon(humanPlayer) === true){
				squares[i] = machinePlayer;//steal victory from human
				turn = (turn === 'X'? 'O':'X');
				drawgame(player1, player2, squares);
				//console.log(i);
				return i;
			}else {squares[i] = '';}  //make the square blank again
		}
	}//end check for block of winning move
	
	function humanCorners(){
		
		var count = 0;
		if (humanPlayer === squares[0]){count = count + 1;}
		if (humanPlayer === squares[2]){count = count + 1;}
		if (humanPlayer === squares[6]){count = count + 1;}
		if (humanPlayer === squares[8]){count = count + 1;}
		return count;
	}
		
/*	Not using this anymore.  The goodmoves function works in this and more situations.
if (humanCorners() === 1){
		console.log('checking for corners');
		if ((humanPlayer === squares[0])&&(squares[8] === '')){
			squares[8] = machinePlayer; 
			turn = (turn === 'X'? 'O':'X');
			drawgame(player1, player2, squares);
			return;
			}
		if (humanPlayer === squares[2]){
			squares[6] = machinePlayer;
			turn = (turn === 'X'? 'O':'X');
			drawgame(player1, player2, squares);
			return;
			}
		if (humanPlayer === squares[8]){
			squares[0] = machinePlayer;
			turn = (turn === 'X'? 'O':'X');
			drawgame(player1, player2, squares);
			return;
			}
		if (humanPlayer === squares[6]){
			squares[2] = machinePlayer;
			turn = (turn === 'X'? 'O':'X');
			drawgame(player1, player2, squares);
			return;
			}
			
	}
*/	
	
	goodMoves = function(player){
		var rowCount = 0, squareCount = 0; compareMoves = []; // holds the number of rows holding two in a row if the corresponding square chosen.  can equal 0,1,2
		var rows = [[0,1,2],[3,4,5],[6,7,8],[0,3,6],[1,4,7],[2,5,8],[0,4,8],[2,4,6]];//array of all posssible 2 in a row choices
		var opponent =  (player === 'X'? 'O':'X');
		for (var i = 0; i < 9; i++){
			rowCount = 0; //reset
			if (squares[i] === ''){
				//console.log('square is empty');
				squares[i] = player;  //try the square to see how rows work out
				for (var j = 0; j < 8; j++){//look at each row
					squareCount = 0; //reset
					//console.log('reset squareCount');
					for (var k = 0; k < 3; k++){//look at each space in each row
						//console.log('squares[rows[j][k]] ' + squares[rows[j][k]]);
						//console.log('j: ' + j + 'k: ' + k);
						if (squares[rows[j][k]] === opponent){
							squareCount = squareCount - 1;
							//console.log('j is: ' + j + 'k is: ' + k + 'sqareCount is: ' + squareCount);
						}
						if (squares[rows[j][k]] === player){
							squareCount = squareCount + 1;
							//console.log('j is: ' + j + 'k is: ' + k + 'sqareCount is: ' + squareCount);
						}
					}
					if (squareCount === 2){
						rowCount+=1;
					}
					
				}
				compareMoves.push([i, rowCount]);
				squares[i] = '';
			}
		}

		return compareMoves;
		
		//iterate for player, each space, each row
		//output array of spaces with spaceIndex to number of 2 in a rows made if space is taken
	
	};
	var tempArr = goodMoves(player2);

	for(var m = 0; m < tempArr.length; m++){
		if (tempArr[m][1] === 2){
		squares[tempArr[m][0]] = machinePlayer;
		turn = (turn === 'X'? 'O':'X');
		drawgame(player1, player2, squares);
		return;
		}
	}
	
	for(var m = 0; m < tempArr.length; m++){
		if (tempArr[m][1] === 1){
		squares[tempArr[m][0]] = machinePlayer;
		turn = (turn === 'X'? 'O':'X');
		drawgame(player1, player2, squares);
		return;
		}
	}
	
	if ((squares[4] === '')){
			squares[4] = machinePlayer;
			turn = (turn === 'X'? 'O':'X');
			drawgame(player1, player2, squares);
			return 4;
	}	
	var corners = [0,2,6,8];
	for (var i = 0; i < 4; i++){
		if (squares[corners[i]] === ''){
			squares[corners[i]] = machinePlayer;
			turn = (turn === 'X'? 'O':'X');
			drawgame(player1, player2, squares);
			return i;
		}
	}
}




