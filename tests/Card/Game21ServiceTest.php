<?php

namespace App\Cardgame\Cardgame21;

use App\Cardgame\DeckOfCards;
use App\Cardgame\Card;
use App\Cardgame\CardHand;
use App\Cardgame\CardGraphic;

use PHPUnit\Framework\TestCase;

/**
 * A class containing a collection of tests for the Game21Service class
 */
class Game21ServiceTest extends TestCase
{
    /**
     * Construct object and verify that the object is a object
     * and has properties, use no arguments.
    */
    Public function testCreateGame21Service(): void
    {
        $deck = new DeckOfCards();
        $gameService = new Game21Service($deck);

        $this->assertIsObject($gameService);
        $this->assertObjectHasProperty('deck', $gameService);
        $this->assertObjectHasProperty('players', $gameService);
        $this->assertObjectHasProperty('bank', $gameService);
        $this->assertObjectHasProperty('currentPlayer', $gameService);
        $this->assertObjectHasProperty('numPlayers', $gameService);
        $this->assertObjectHasProperty('bankHasPlayed', $gameService);
        $this->assertObjectHasProperty('gameFinished', $gameService);
        $this->assertObjectHasProperty('firstRoundDraw', $gameService);
        $this->assertObjectHasProperty('secondRoundDraw', $gameService);
    }

    /**
     * Construct object and verify that the
     * initialization of the game works as intended
    */
    Public function testInitializeGame(): void
    {
        $deck = new DeckOfCards();
        $gameService = new Game21Service($deck);
        $numPlayers = 5;

        $deckPreInitializedGame = $gameService->getDeck();
        $gameService->initializeGame($numPlayers);
        $deckPostInitializedGame = $gameService->getDeck();

        $this->assertNotEquals($deckPreInitializedGame, $deckPostInitializedGame, 'Deck has not changed after shuffling in initialization of game');
        $this->assertEquals($deck, $deckPreInitializedGame, 'Given and gotten deck does not match');
        $this->assertObjectHasProperty('bank', $gameService);
    }

    /**
     * Construct object and verify that the drawFirstRound method works as intended
     *
    */
    Public function testDrawFirstRound(): void
    {
        $deck = new DeckOfCards();
        $gameService = new Game21Service($deck);
        $numPlayers = 5;

        $deckPreInitializedGame = $gameService->getDeck();
        $gameService->initializeGame($numPlayers);

        $gameService->drawFirstRound();
        $deckPostFirstDraw = $gameService->getDeck();

        $drawnBoolArray = $gameService->cardsDealt();

        $this->assertCount(46, $deckPostFirstDraw->getCards());
        $this->assertTrue($drawnBoolArray['firstRoundDraw']);
        $this->assertFalse($drawnBoolArray['secondRoundDraw']);
    }

    /**
     * Construct object and verify that the drawSecoundRound method works as intended
     *
    */
    Public function testDrawSecoundRound(): void
    {
        $deck = new DeckOfCards();
        $gameService = new Game21Service($deck);
        $numPlayers = 5;

        $deckPreInitializedGame = $gameService->getDeck();
        $gameService->initializeGame($numPlayers);

        $gameService->drawSecondRound();
        $deckPostFirstDraw = $gameService->getDeck();

        $drawnBoolArray = $gameService->cardsDealt();

        $this->assertCount(47, $deckPostFirstDraw->getCards());
        $this->assertFalse($drawnBoolArray['firstRoundDraw']);
        $this->assertTrue($drawnBoolArray['secondRoundDraw']);
    }

    /**
     * Construct object and verify that the dealCardToPlayer method works as intended
     *
    */
    Public function testDealCardToPlayer(): void
    {
        $deck = new DeckOfCards();
        $gameService = new Game21Service($deck);
        $numPlayers = 5;

        $deckPreInitializedGame = $gameService->getDeck();
        $gameService->initializeGame($numPlayers);

        $gameService->dealCardToPlayer(1);
        $deckPostDraw = $gameService->getDeck();

        $this->assertCount(51, $deckPostDraw->getCards());
    }

    /**
     * Construct object and verify that the dealCardToBank method works as intended
     *
    */
    Public function testDealCardToBank(): void
    {
        $deck = new DeckOfCards();
        $gameService = new Game21Service($deck);
        $numPlayers = 5;

        $gameService->initializeGame($numPlayers);
        $cardDelt = $gameService->dealCardToBank();

        $this->assertNotNull($cardDelt, 'dealCardToBank() returned null.');

        $cardDelt->setSuit('Apple');
        $suitOfCard = $cardDelt->getSuit();

        $this->assertIsObject($cardDelt);
        $this->assertEquals('Apple', $suitOfCard);
    }

    /**
     * Construct object and verify that the getPlayerCards method works as intended
     * when no player has cards
     *
    */
    Public function testGetPlayerCardsWhenNoCards(): void
    {
        $deck = new DeckOfCards();
        $gameService = new Game21Service($deck);
        $numPlayers = 5;

        $gameService->initializeGame($numPlayers);
        $playersCards1 = $gameService->getPlayerCards(0);
        $playersCards2 = $gameService->getPlayerCards(1);
        $playersCards3 = $gameService->getPlayerCards(2);
        $playersCards4 = $gameService->getPlayerCards(3);
        $playersCards5 = $gameService->getPlayerCards(4);

        $this->assertCount(0, $playersCards1);
        $this->assertCount(0, $playersCards2);
        $this->assertCount(0, $playersCards3);
        $this->assertCount(0, $playersCards4);
        $this->assertCount(0, $playersCards5);
    }

    /**
     * Construct object and verify that the getPlayerCards method works as intended
     * when player have cards
     *
    */
    Public function testGetPlayerCardsWhenPlayersHaveCards(): void
    {
        $deck = new DeckOfCards();
        $gameService = new Game21Service($deck);
        $numPlayers = 5;
        $gameService->initializeGame($numPlayers);

        $gameService->drawFirstRound();
        $playersCards1 = $gameService->getPlayerCards(0);
        $playersCards2 = $gameService->getPlayerCards(1);
        $playersCards3 = $gameService->getPlayerCards(2);
        $playersCards4 = $gameService->getPlayerCards(3);
        $playersCards5 = $gameService->getPlayerCards(4);

        $this->assertCount(1, $playersCards1);
        $this->assertCount(1, $playersCards2);
        $this->assertCount(1, $playersCards3);
        $this->assertCount(1, $playersCards4);
        $this->assertCount(1, $playersCards5);

        $gameService->drawSecondRound();

        $playersCards1 = $gameService->getPlayerCards(0);
        $playersCards2 = $gameService->getPlayerCards(1);
        $playersCards3 = $gameService->getPlayerCards(2);
        $playersCards4 = $gameService->getPlayerCards(3);
        $playersCards5 = $gameService->getPlayerCards(4);

        $this->assertCount(2, $playersCards1);
        $this->assertCount(2, $playersCards2);
        $this->assertCount(2, $playersCards3);
        $this->assertCount(2, $playersCards4);
        $this->assertCount(2, $playersCards5);
    }

    /**
     * Construct object and verify that the getBankCards method works as intended
     *
    */
    Public function testGetBankCards(): void
    {
        $deck = new DeckOfCards();
        $gameService = new Game21Service($deck);
        $numPlayers = 5;
        $gameService->initializeGame($numPlayers);

        $bankWithNoCards = $gameService->getBankCards();
        $gameService->drawFirstRound();
        $bankWithACard = $gameService->getBankCards();

        $this->assertCount(0, $bankWithNoCards);
        $this->assertCount(1, $bankWithACard);
    }

    /**
     * Construct object and verify that the getPlayers method works as intended
     *
    */
    Public function testGetPlayers(): void
    {
        $deck = new DeckOfCards();
        $gameService = new Game21Service($deck);
        $numPlayers = 5;
        $gameService->initializeGame($numPlayers);

        $arrayOfPlayers = $gameService->getPlayers();

        $this->assertCount(5, $arrayOfPlayers);
    }

    /**
     * Construct object and verify that the nextPlayer method works as intended
     *
    */
    Public function testNextPlayer(): void
    {
        $deck = new DeckOfCards();
        $gameService = new Game21Service($deck);
        $numPlayers = 5;
        $gameService->initializeGame($numPlayers);

        $previousPlayer = $gameService->currentPlayer();
        $currentPlayer = $gameService->nextPlayer();

        $this->assertNotEquals($previousPlayer, $currentPlayer);
        $this->assertEquals(0, $previousPlayer);
        $this->assertEquals(1, $currentPlayer);
        $this->assertIsInt($currentPlayer);
    }

    /**
     * Construct object and verify that the calculateCardValue method works as intended
     *
    */
    Public function testCalculateCardValue(): void
    {
        $deck = new DeckOfCards();
        $gameService = new Game21Service($deck);
        $numPlayers = 5;
        $gameService->initializeGame($numPlayers);

        $suit = 'Spades';
        $rank = 'King';
        $cardKing = new Card($suit, $rank);

        $suit = 'Spades';
        $rank = 'Ace';
        $cardAce = new Card($suit, $rank);

        $suit = 'Spades';
        $rank = '2';
        $card2 = new Card($suit, $rank);

        $cardKingValue = $gameService->calculateCardValue($cardKing);
        $cardAceValue = $gameService->calculateCardValue($cardAce);
        $card2Value = $gameService->calculateCardValue($card2);

        $this->assertIsInt($cardKingValue);
        $this->assertIsInt($cardAceValue);
        $this->assertIsInt($card2Value);
        $this->assertEquals(10, $cardKingValue);
        $this->assertEquals(11, $cardAceValue);
        $this->assertEquals(2, $card2Value);
    }

    /**
     * Construct object and verify that the calculateHandValue method works as intended
     *
    */
    Public function testCalculateHandValue(): void
    {
        $deck = new DeckOfCards();
        $gameService = new Game21Service($deck);
        $numPlayers = 5;
        $gameService->initializeGame($numPlayers);

        $suit = 'Spades';
        $rank = 'King';
        $cardKing = new Card($suit, $rank);

        $suit = 'Spades';
        $rank = 'Ace';
        $cardAce = new Card($suit, $rank);

        $suit = 'Spades';
        $rank = '2';
        $card2 = new Card($suit, $rank);

        $handOfCards = new CardHand();
        $handOfCards->addCard($cardKing);
        $handOfCards->addCard($cardAce);
        $handOfCards->addCard($card2);

        $handValue = $gameService->calculateHandValue($handOfCards);

        $this->assertIsObject($handOfCards);
        $this->assertIsInt($handValue);
        $this->assertEquals(13, $handValue);
    }

    /**
     * Construct object and verify that the calculatePlayersHandValue method
     * takes each players hand and runs it through the calculateHandValaue as intended
     *
    */
    Public function testCalculatePlayersHandValue(): void
    {
        $deck = new DeckOfCards();
        $gameService = new Game21Service($deck);
        $numPlayers = 3;
        $gameService->initializeGame($numPlayers);

        $gameService->drawFirstRound();

        $arrayOfHandValues = $gameService->calculatePlayersHandValue();

        $this->assertCount(3, $arrayOfHandValues);
        $this->assertIsInt($arrayOfHandValues[0]);
        $this->assertIsInt($arrayOfHandValues[1]);
        $this->assertIsInt($arrayOfHandValues[2]);
    }
    
    /**
     * Construct object and verify that the calculateBankHandValue method
     * takes the bank hand and runs it through the calculateHandValaue as intended
     *
    */
    Public function testCalculateBankHandValue(): void
    {
        $deck = new DeckOfCards();
        $gameService = new Game21Service($deck);
        $numPlayers = 3;
        $gameService->initializeGame($numPlayers);

        $bankHandValueEmpty = $gameService->calculateBankHandValue();
        $gameService->drawFirstRound();
        $bankHandValue = $gameService->calculateBankHandValue();

        $this->assertIsInt($bankHandValueEmpty);
        $this->assertIsInt($bankHandValue);
        $this->assertNotEquals($bankHandValue, $bankHandValueEmpty);
        $this->assertEquals(0, $bankHandValueEmpty);
    }

    /**
     * Construct object and verify that the dealerTurn method
     * deals cards to the dealer as intended
     *
    */
    Public function testDealerTurn(): void
    {
        $deck = new DeckOfCards();
        $gameService = new Game21Service($deck);
        $numPlayers = 3;
        $gameService->initializeGame($numPlayers);
        $bankValueAbove16 = FALSE;

        $gameService->dealerTurn();
        $dealersCards = $gameService->getBankCards();

        foreach ($dealersCards as $card) {
            $arrayBankValues[] = $gameService->calculateCardValue($card);
        }

        $totalBankValue = array_sum($arrayBankValues);

        $dealerCutof = 16;
        if ($totalBankValue > $dealerCutof) {
            $bankValueAbove16 = TRUE;
        }

        $this->assertTrue($bankValueAbove16);
    }

    /**
     * Construct object and verify that the determineWinners method
     * check who tied as intended
     *
    */
    Public function testDetermineWinnersTie(): void
    {
        $deck = new DeckOfCards();
        $gameService = new Game21Service($deck);
        $numPlayers = 1;
        $gameService->initializeGame($numPlayers);

        $whoWonArray = $gameService->determineWinners();

        $this->assertIsArray($whoWonArray);
        $this->assertEquals('Tie', $whoWonArray[0]);
    }

    /**
     * Construct object and verify that the determineWinners method
     * check who Won as intended
     *
    */
    Public function testDetermineWinnersWon(): void
    {
        $deck = new DeckOfCards();
        $gameService = new Game21Service($deck);
        $numPlayers = 1;
        $gameService->initializeGame($numPlayers);

        $currentPlayer = 0;
        $gameService->dealCardToPlayer($currentPlayer);
        $whoWonArray = $gameService->determineWinners();

        $this->assertIsArray($whoWonArray);
        $this->assertEquals('Win', $whoWonArray[0]);
    }

    /**
     * Construct object and verify that the determineWinners method
     * check who Lost as intended
     *
    */
    Public function testDetermineWinnersLose(): void
    {
        $deck = new DeckOfCards();
        $gameService = new Game21Service($deck);
        $numPlayers = 1;
        $gameService->initializeGame($numPlayers);

        $gameService->dealCardToBank();
        $whoWonArray = $gameService->determineWinners();

        $this->assertIsArray($whoWonArray);
        $this->assertEquals('Lose', $whoWonArray[0]);
    }

    /**
     * Construct object and verify that the isGameFinished method
     * check if the game is finnished or not as intended and
     * if finishGame correctly sets flag as true
     *
    */
    Public function testIsGameFinishedAndFinishGame(): void
    {
        $deck = new DeckOfCards();
        $gameService = new Game21Service($deck);
        $numPlayers = 1;
        $gameService->initializeGame($numPlayers);

        $isGameFinishedFalse = $gameService->isGameFinished();
        $gameService->finishGame();
        $isGameFinishedTrue = $gameService->isGameFinished();

        $this->assertFalse($isGameFinishedFalse);
        $this->assertTrue($isGameFinishedTrue);
    }

    /**
     * Construct object and verify that the getPlayerCount method
     * gets the player count as intended
     *
    */
    Public function testGetPlayerCount(): void
    {
        $deck = new DeckOfCards();
        $gameService = new Game21Service($deck);
        $numPlayers = 10;
        $gameService->initializeGame($numPlayers);

        $res = $gameService->getPlayerCount();

        $this->assertIsInt($res);
        $this->assertEquals(10, $res);
    }

    /**
     * Cunstruct object and verify that the jsonSerialize works as expected
     * properties, use both arguments.
     */
    public function testJsonSerialize(): void
    {
        $deck = new DeckOfCards();
        $gameService = new Game21Service($deck);
        $numPlayers = 3;
        $gameService->initializeGameNoShuffle($numPlayers);
        $gameService->dealCardToPlayer(0);
        $gameService->dealCardToPlayer(1);
        $gameService->dealCardToPlayer(1);
        $suit = 'Spades';
        $rank = 'Ace';
        $card = new Card($suit, $rank);

        $json = json_encode($gameService->jsonSerialize());
        $expectedJson = json_encode([
            'bank' => [
                'cards' => []
            ],
            "banksHandValue" => 0,
            "bools" => [
                "bankHasPlayed" => false,
                "firstRoundDraw" => false,
                "gameFinished" => false,
                "secondRoundDraw" => false
            ],
            "currentPlayer" => 0,
            "deck" => [
                "cards" => [
                    ["rank" => "2", "suit" => "Spades"],
                    ["rank" => "3", "suit" => "Spades"],
                    ["rank" => "4", "suit" => "Spades"],
                    ["rank" => "5", "suit" => "Spades"],
                    ["rank" => "6", "suit" => "Spades"],
                    ["rank" => "7", "suit" => "Spades"],
                    ["rank" => "8", "suit" => "Spades"],
                    ["rank" => "9", "suit" => "Spades"],
                    ["rank" => "10", "suit" => "Spades"],
                    ["rank" => "Jack", "suit" => "Spades"],
                    ["rank" => "Queen", "suit" => "Spades"],
                    ["rank" => "King", "suit" => "Spades"],
                    ["rank" => "Ace", "suit" => "Spades"],
                    ["rank" => "2", "suit" => "Hearts"],
                    ["rank" => "3", "suit" => "Hearts"],
                    ["rank" => "4", "suit" => "Hearts"],
                    ["rank" => "5", "suit" => "Hearts"],
                    ["rank" => "6", "suit" => "Hearts"],
                    ["rank" => "7", "suit" => "Hearts"],
                    ["rank" => "8", "suit" => "Hearts"],
                    ["rank" => "9", "suit" => "Hearts"],
                    ["rank" => "10", "suit" => "Hearts"],
                    ["rank" => "Jack", "suit" => "Hearts"],
                    ["rank" => "Queen", "suit" => "Hearts"],
                    ["rank" => "King", "suit" => "Hearts"],
                    ["rank" => "Ace", "suit" => "Hearts"],
                    ["rank" => "2", "suit" => "Diamonds"],
                    ["rank" => "3", "suit" => "Diamonds"],
                    ["rank" => "4", "suit" => "Diamonds"],
                    ["rank" => "5", "suit" => "Diamonds"],
                    ["rank" => "6", "suit" => "Diamonds"],
                    ["rank" => "7", "suit" => "Diamonds"],
                    ["rank" => "8", "suit" => "Diamonds"],
                    ["rank" => "9", "suit" => "Diamonds"],
                    ["rank" => "10", "suit" => "Diamonds"],
                    ["rank" => "Jack", "suit" => "Diamonds"],
                    ["rank" => "Queen", "suit" => "Diamonds"],
                    ["rank" => "King", "suit" => "Diamonds"],
                    ["rank" => "Ace", "suit" => "Diamonds"],
                    ["rank" => "2", "suit" => "Clubs"],
                    ["rank" => "3", "suit" => "Clubs"],
                    ["rank" => "4", "suit" => "Clubs"],
                    ["rank" => "5", "suit" => "Clubs"],
                    ["rank" => "6", "suit" => "Clubs"],
                    ["rank" => "7", "suit" => "Clubs"],
                    ["rank" => "8", "suit" => "Clubs"],
                    ["rank" => "9", "suit" => "Clubs"],
                    ["rank" => "10", "suit" => "Clubs"],
                    ["rank" => "Jack", "suit" => "Clubs"]
                ]
            ],
            "players" => [
                [
                    "cards" => [
                        ["rank" => "Ace", "suit" => "Clubs"]
                    ]
                ],
                [
                    "cards" => [
                        ["rank" => "King", "suit" => "Clubs"],
                        ["rank" => "Queen", "suit" => "Clubs"]
                    ]
                ],
                [
                    "cards" => []
                ]
            ],
            "playersHandValues" => [
                11,
                20,
                0
            ],
            "totalPlayers" => 3
        ]);

        $this->assertJsonStringEqualsJsonString($expectedJson, $json, 'gameService JSON serialization is incorrect');
    }
}