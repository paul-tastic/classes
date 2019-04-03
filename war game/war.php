<?php
session_start(); 

if (!isset($_SESSION['player1cards'])) {
	$_SESSION['player1cards'] = array();
	$_SESSION['player2cards'] = array();
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>War!</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<style type="text/css">
		#main-container {
			width: 70%;
			margin: 20px auto;
		}
		#title-row {
			text-align: center;
			height: 70px;
			margin-bottom: 30px;
		}
		#score-row {

		}
		.score-col {
			min-height: 100px;
			text-align: center;
		}
		.score-box-lower {
			height: 75%;
			border: 1px solid black;
			font-size: 2.8rem;
		}
		.score-box-top {
			height: 25%;
			
		}
		#battlefield-row {
			
		}
		#comment-row {
			text-align: center;
			height: 75px;
			margin: 8px auto;
		}
		#deal-button-row {

		}
		#shuffle-button-row {

		}
		.b-row {
			text-align: center;
			margin: 10px auto;
		}
		.buttons {
			width: 130px;
		}
		#round-number {
			text-align: center;
		}
		.battlefield {
			margin-top: 12px;
		}
		.winner {
			color: #155724;
			background-color: #d4edda;
		}

	</style>
</head>
<body>
	<div class="container" id="main-container">
		<div class="row" id="title-row">
			<div class="col-md-12">
				<h2>War!</h2>
				<h4 id="round-number"></h4>
			</div>
		</div>
		<div class="row" id="score-row">
			<div class="col-md-3 offset-md-3 score-col" id="score1side">
				<div class="score-box-top">Player 1</div>
				<div class="score-box-lower" id="p1score"></div>
			</div>
			<div class="col-md-3 score-col" id="score2side">
				<div class="score-box-top">Player 2</div>
				<div class="score-box-lower" id="p2score"></div>
			</div>
		</div>
		<div class="row" id="battlefield-row">
			<div class='col-md-3 offset-md-3 score-col' id='battlefield1side'>
				<div class='battlefield' id='p1battlefield'></div>
			</div>
			<div class='col-md-3 score-col' id='battlefield2side'>
				<div class='battlefield' id='p2battlefield'></div>
			</div>
		</div>
		<div id="comment-row"></div>
		<div class="b-row" id="deal-button-row">
			<button type="button" class="btn btn-outline-success buttons" name="start" id="start" onclick="startGame();">Start New Game!</button>
			<button type="button" class="btn btn-outline-primary buttons" name="deal" id="deal" onclick="dealAJAX();">Deal!</button>
		</div>
	</div>
	<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

	<script type="text/javascript">

		var warRound;
		var p1Score;
		var p2Score;
		$('#deal').hide();

		function updateScoreboard() {
    		$('#round-number').text("Round: "+ warRound);
			$('#p1score').text(p1Score);
			$('#p2score').text(p2Score);
		}

		function startGame() {
    		$('.score-box-lower').removeClass('winner');
			$('#p1battlefield').text("");
    		$('#p2battlefield').text("");	
    		$('#comment-row').text('Shuffling the cards!');
			//shuffle cards

			setTimeout(func, 1000);
				function func() {
				$('#start').hide();
				$('#deal').show();
					
					$.ajax ({
			          url: 'warAjax.php',
			          method: 'POST',
			          dataType: 'json',
			          data: {
			            key : 'shuffle',
			          }, 
			          success: function (response) {
			              // shuffle and deal the cards
						$('#loader').hide();

		    			$('#comment-row').text(response.message);
    					warRound = response.warRound;
    					p1Score = response.p1Score;
    					p2Score = response.p2Score;
    					updateScoreboard(p1Score, p2Score, warRound);
			            }
			         }); 
				}
		}

		function dealAJAX() {
			$.ajax ({
	          url: 'warAjax.php',
	          method: 'POST',
	          dataType: 'json',
	          cache: false,
	          data: {
	            key : 'deal',
	            warRound: warRound,
	            p1Score: p1Score,
	            p2Score: p2Score,
	          }, 
	          success: function (response) {
	          	$('#comment-row').text('');
    			warRound = response.warRound;
    			p1Score = response.p1Score;
    			p2Score = response.p2Score;
    			$('#p1battlefield').text("The " + response.p1Card + " of " + response.p1Suit);
    			$('#p2battlefield').text("The " + response.p2Card + " of " + response.p2Suit);	
    			updateScoreboard(p1Score, p2Score, warRound);
    			if (warRound == 26) {
    				// game over!!
    				// swap buttons
    				$('#start').show();
    				$('#deal').hide();
    				// display winner screen
    				if (p1Score > p2Score) {
    					// p1 wins!
    					$('#comment-row').html('<div class="alert alert-success" role="alert">Player 1 Wins!!</div>');
    					$('#p1score').addClass('winner');
    				} else if (p1Score < p2Score) {
    					// p2 wins!
    					$('#comment-row').html('<div class="alert alert-success" role="alert">Player 2 Wins!!</div>');
    					$('#p2score').addClass('winner');
    					
    				} else {
    					// tie!
    					$('#comment-row').html('<div class="alert alert-info" role="alert">A tie?? Like kissing your sister!</div>');
    				}
    			}
	            }
	          }); 
		}





	</script>
</body>
</html>