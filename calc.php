<?php

$answer = "";

class Calculator {
		private $_arg1, $_arg2;

		public function __construct($arg1, $arg2) {
			if ((!is_numeric($arg1)) || (!is_numeric($arg2))) {
				return $answer = "invalid entry, not a number";
			}
			$this->_arg1 = $arg1;
			$this->_arg2 = $arg2;
		}

		public function add() {
			// echo $char1.' '.$char2."\r\n";
			return $this->_arg1 + $this->_arg2;
		}

		public function mul() {
			return $this->_arg1 * $this->_arg2;
		}
		public function div() {
			return $this->_arg1 / $this->_arg2;
		}

		public function sub() {
			return $this->_arg1 - $this->_arg2;
		}

		public function square() {
			return pow ($this->_arg1, $this->_arg2);
		}

		public function surprise() {
			return $answer = "710.77345";
		}
	}

	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$char1 = $_POST['numOne'];
		$char2 = $_POST['numTwo'];
		$math = new Calculator($char1, $char2);
		if (isset($_POST['add'])) {
			$answer = $math->add();
		}
		if (isset($_POST['sub'])) {
			$answer = $math->sub();
		}
		if (isset($_POST['div'])) {
			$answer = $math->div();
		}
		if (isset($_POST['mul'])) {
			$answer = $math->mul();
		}
		if (isset($_POST['surprise'])) {
			$answer = $math->surprise();
			$comment = "Turn your monitor upside down to read it.";
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Calulator</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link href="https://fonts.googleapis.com/css?family=ZCOOL+QingKe+HuangYou" rel="stylesheet">
	<style type="text/css">

		#main-container {
			width: 60%;
			margin: 0 auto;
		}
		.inner-div {
			margin: 0 auto;
			text-align: center;
		}

		#answer-div {
			letter-spacing: 4px;
			height: 75px;
			background-color: lightyellow;
			margin: 15px auto;
			padding: 5px;
			font-family: 'ZCOOL QingKe HuangYou', cursive;
			font-weight: 700;
			font-size: 2.5rem;
		}
		#comment-div {
			background-color: white;
			margin: 15px auto;
			vertical-align: middle;
			font-family: 'ZCOOL QingKe HuangYou', cursive;
			font-size: 1.6rem;
			transform: rotateX(-180deg);
		}

		input {
			width: 25%;
		}
	</style>

</head>
<body>
	<div class="container" id="main-container">
		<div class="container inner-div" id="answer-div"><?php echo $answer; ?></div>
		<div class="container inner-div" id="calc-body">
			<form id="calc-form" action="" method="POST">
				<div>
					<input type="text" name="numOne" placeholder="number 1">
					<input type="text" name="numTwo" placeholder="number 2">
				</div>
				<div style="margin: 15px auto;">
					<button class="btn btn-primary" type="submit" name="add">add</button>
					<button class="btn btn-primary" type="submit" name="sub">sub</button>
					<button class="btn btn-primary" type="submit" name="mul">mul</button>
					<button class="btn btn-primary" type="submit" name="div">div</button>
				</div>
					<button class="btn btn-secondary" type="submit" name="surprise">old school me</button>
				<div>
				<div class="container inner-div" id="comment-div"><?php echo $comment; ?></div>
					
				</div>
			</form>
		</div>
	</div>
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
