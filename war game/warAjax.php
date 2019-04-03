<?php
session_start();

	class PlayingCard {
		private $cardNumber;
		private $suit;
		private $rank;
		private $number;
		private $played;

		public function __construct($card) {
			$this->cardNumber = $card;
			//52 cards in a deck, 0-12 = hearts, 13-25 = diamonds, 26-38 clubs, 39-51 spades
			// cards: 0 = Ace, 2-10, 11 = Jack, 12= queen, 1 = king

			if ($card < 14) {
				// hearts
				$this->suit = "Hearts";
				$this->rank = $card;
			} else if ($card < 27) {
				// diamonds
				$this->suit = "Diamonds";
				$this->rank = $card-13;
			} else if ($card < 40) {
				// clubs
				$this->suit = "Clubs";
				$this->rank = $card-26;
			} else if ($card < 53) {
				// spades
				$this->suit = "Spades";
				$this->rank = $card-39;
			}
				
			switch ($card) {
				case 1:
				case 14:
				case 27:
				case 40: 
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

	// *************************************************************
	// *************************************************************
	// *************************************************************

	if ($_POST['key'] === "shuffle") {
		// deal 52 cards, shuffle them, and split the deck in half!
		$player1cards = array(); 
		$player2cards = array();
		$warRound = 0;
		$cards = array();
		for ($i=0; $i<52; $i++) {
			$cards[$i] = $i;
			}
			$cards[0] = 52;
			shuffle($cards);
			$player1cards = array_slice($cards, 0, 26);
			$player2cards = array_slice($cards, 26, 26);
			// cut the deck!
			$player1cards[26] = $player1cards[0];
			$player2cards[26] = $player2cards[0];
		// set and initialize session variable to store cards and stats
		$_SESSION['player1cards'] = $player1cards;
		$_SESSION['player2cards'] = $player2cards;
		// $_SESSION['warRound'] = 0;
		// $_SESSION['player1score'] = 0;
		// $_SESSION['player2score'] = 0;
		$p1Score = 0;
		$p2Score = 0;

		echo json_encode(array(
			"message" => "cards shuffled, ready to deal!",
			"p1Score" => $p1Score,
			"p2Score" => $p2Score,
			"warRound" => $warRound
		));
	
	} // shuffled!

	// *************************************************************
	// *************************************************************
	// *************************************************************

	if ($_POST['key'] === "deal") {

		//increment session
		$warRound = $_POST['warRound'];
		$warRound++;
		$p1Score = $_POST['p1Score'];
		$p2Score = $_POST['p2Score'];

		// pull data from session variable
		$player1cards = $_SESSION['player1cards'];
		$player2cards = $_SESSION['player2cards'];
		
		//get next Card from players
		$p1Card = new PlayingCard($player1cards[$warRound]);
		$p2Card = new PlayingCard($player2cards[$warRound]);
		
		$player1rank = $p1Card->getRank();
		$player1card = $p1Card->getCardNumber();
		$player1suit = $p1Card->getSuit();
		$p1CardDecoded = assignRank($player1rank);
		
		$player2rank = $p2Card->getRank();
		$player2card = $p2Card->getCardNumber();
		$player2suit = $p2Card->getSuit();
		$p2CardDecoded = assignRank($player2rank);

		//get the score
		if ($player1rank > $player2rank) {
			$p1Score++;
		} elseif ($player1rank < $player2rank) {
			$p2Score++;
		} elseif ($player1rank == $player2rank) {
			//tie, more logic to break tie 
		}

		echo json_encode(array(
			"p1Card" => $p1CardDecoded, 
			"p1Suit" => $player1suit,
			"p2Card" => $p2CardDecoded, 
			"p2Suit" => $player2suit,
			"p1Score" => $p1Score,
			"p2Score" => $p2Score,
			"warRound" => $warRound
		));

	}
} //  REQUEST METHOD

?>