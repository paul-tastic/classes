<?php
session_start();

	class PlayingCard {
		private $cardNumber;
		private $suit;
		private $rank;
		private $number;
		private $played;

		public function __construct($cardNumber) {
			$this->cardNumber = $cardNumber;
			//52 cards in a deck, 0-12 = hearts, 13-25 = diamonds, 26-38 clubs, 39-51 spades
			// cards: 0 = Ace, 2-10, 11 = Jack, 12= queen, 1 = king

			if ($cardNumber < 14) {
					// hearts
					$this->suit = "hearts";
					$this->rank = $cardNumber;
				} else if ($cardNumber < 27) {
					// diamonds
					$this->suit = "diamonds";
					$this->rank = $cardNumber-13;
				} else if ($cardNumber < 40) {
					// clubs
					$this->suit = "clubs";
					$this->rank = $cardNumber-26;
				} else if ($cardNumber < 53) {
					// spades
					$this->suit = "spades";
					$this->rank = $cardNumber-39;
				}
				
			switch ($cardNumber) {
				case 1:
				case 14:
				case 27:
				case 39: 
					$this->rank = 14;
					// all the aces!
					break;
				case 13:
				case 26:
				case 39:
				case 52: 
					$this->rank = 13;
					// all the kings!
					break;
				case 12:
				case 25:
				case 38:
				case 51: 
					$this->rank = 12;
					// all the queens!
					break;
				case 11:
				case 24:
				case 37:
				case 50: 
					$this->rank = 11;
					// all the jacks!
					break;
				default: break;
			}
			$this->played = "not-played";
		}

		public function getCardNumber() {
			return $this->cardNumber;
		}

		public function getSuit() {
			return $this->suit;
		}

		public function getRank() {
			return $this->rank;
		}
		
		public function playedCard() {
			return $this->$played = "played";
		}
	} // PlayingCard class

function assignRank($card) {

		switch ($card) {
			case 14:
				$card = "Ace";
				break;
			case 13:
				$card = "King";
				break;
			case 12:
				$card = "Queen";
				break;
			case 11:
				$card = "Jack";
				break;
			default:
				break;
		}
		return $card;
}

IF ($_SERVER["REQUEST_METHOD"] === "POST") {

	if ($_POST['key'] === "shuffle") {
		// deal 52 cards, shuffle them, and split the deck in half!
			$player1cards = array(); 
			$player2cards = array();
			$cards = array();
			for ($i=1; $i<53; $i++) {
				$cards[$i] = $i;
				shuffle($cards);
				$player1cards = array_slice($cards, 1, 27);
				$player2cards = array_slice($cards, 27, 26);
			}

		// set and initialize session variable to store cards and stats
		$_SESSION['player1cards'] = $player1cards;
		$_SESSION['player2cards'] = $player2cards;
		$_SESSION['warRound'] = 0;
		$_SESSION['player1score'] = 0;
		$_SESSION['player2score'] = 0;

		echo "cards shuffled, ready to deal!";
	
	} // shuffled!

	if ($_POST['key'] === "deal") {

		// pull data from session variable
		// $p1score = $_SESSION['player1score'];
		// $p2score = $_SESSION['player2score'];
		$player1cards = $_SESSION['player1cards'];
		$player2cards = $_SESSION['player2cards'];
		
		//get next Card from players
		$p1Card = new PlayingCard($player1cards[$_SESSION['warRound']]);
		$p2Card = new PlayingCard($player2cards[$_SESSION['warRound']]);
		
		$player1rank = $p1Card->getRank();
		$player1card = $p1Card->getCardNumber();
		$player1suit = $p1Card->getSuit();

		$player2rank = $p2Card->getRank();
		$player2card = $p2Card->getCardNumber();
		$player2suit = $p2Card->getSuit();

		//get the score
		if ($player1rank > $player2rank) {
			$_SESSION['player1score']++;
		} elseif ($player1rank < $player2rank) {
			$_SESSION['player2score']++;
		} elseif ($player1rank == $player2rank) {
			//tie, more logic to break tie 
		}

		$player1rank = assignRank($player1rank);
		$player2rank = assignRank($player2rank);

		//increment session
		$_SESSION['warRound']++;
		
		echo "
		<div class='col-md-3 offset-md-3 score-col' id='battlefield1side'>
			<div class='battlefield' id='p1battlefield'>
				The {$player1rank} of {$player1suit}
			</div>
		</div>
		<div class='col-md-3 score-col' id='battlefield2side'>
			<div class='battlefield' id='p2battlefield'>
				The {$player2rank} of {$player2suit}
			</div>
		</div>
					";
	}
} // original POST

?>