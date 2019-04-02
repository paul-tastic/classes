<?php 
	session_start(); 
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
			font-size: 2.6rem;
		}
		.score-box-top {
			height: 25%;
			
		}
		#battlefield-row {
			height: 50px;
		}
		#comment-row {
			text-align: center;
			height: 50px;
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
		<div class="row" id="battlefield-row"></div>
		<div id="comment-row"></div>
		<div class="b-row" id="deal-button-row">
			<button type="button" class="btn btn-outline-success buttons" name="start" id="start" onclick="startGame();">Start Game!</button>
			<button type="button" class="btn btn-success buttons" name="deal" id="deal" onclick="dealAJAX();">Deal!</button>
		</div>
	</div>
	<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

	<script type="text/javascript">


		$('#deal').hide();

		function startGame() {
    		$('#comment-row').text('Shuffling the cards!');
			//shuffle
			setTimeout(func, 3000);
				function func() {
    				$('#start').hide();
    				$('#deal').show();
					$.ajax ({
			          url: 'warAjax.php',
			          method: 'POST',
			          dataType: 'text',
			          data: {
			            key : 'shuffle',
			          }, 
			          success: function (response) {
			              // shuffle and deal the cards
		    			$('#comment-row').text(response);
		    			$('#p1score').text(<?php echo $_SESSION['player1score']; ?>);
		    			$('#p2score').text(<?php echo $_SESSION['player2score']; ?>);
		    			$('#round-number').text("Round: "+ <?php echo $_SESSION['warRound']; ?>);
			            }
			         }); 
				}
		}

		function dealAJAX() {
			$.ajax ({
	          url: 'warAjax.php',
	          method: 'POST',
	          dataType: 'text',
	          data: {
	            key : 'deal',
	          }, 
	          success: function (response) {
	          	$('#comment-row').text('');
    			$('#battlefield-row').html(response);
    			$('#p1score').text(<?php echo $_SESSION['player1score']; ?>);
    			$('#p2score').text(<?php echo $_SESSION['player2score']; ?>);
    			$('#round-number').text("Round: "+ <?php echo $_SESSION['warRound']; ?>);
	            }
	          }); 
		}





	</script>
</body>
</html>