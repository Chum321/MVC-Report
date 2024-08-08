<?php

namespace App\Cardgame;

use PHPUnit\Framework\TestCase;

/**
 * A class containing a collection of tests for the DeckOfCards class
 */
class DeckOfCardsTest extends TestCase
{
    /**
     * Construct object and verify that the object is a object, use no arguments.
     */
    public function testCreateDeckOfCards(): void
    {
        $deck = new DeckOfCards();
        $this->assertIsObject($deck);
    }

    /**
     * Construct object and verify that the methods
     * getCards and setCards work as intended, use no arguments.
     */
    public function testGetAndSetCards(): void
    {
        $deck = new DeckOfCards();

        $suit = 'Spades';
        $rank = 'Ace';
        $card = new Card($suit, $rank);

        $cards = [$card];

        $res = $deck->getCards();
        $deck->setCards($cards);
        $res2 = $deck->getCards();

        $this->assertCount(52, $res);
        $this->assertCount(1, $res2);
    }

    /**
     * Construct object and verify that the method
     * shuffle work as intended, use no arguments.
     */
    public function testShuffle(): void
    {
        $deck = new DeckOfCards();

        $originalArrayOfCards = $deck->getCards();
        $deck->shuffle();
        $shuffledArrayOfCards = $deck->getCards();

        $this->assertNotEquals($originalArrayOfCards, $shuffledArrayOfCards, 'Array has not changed after shuffling');
    }

    public function testJsonSerialize(): void
    {
        // Deck to be tested on
        $deck = new DeckOfCards();

        // Expected array format for jsonSerialize
        $expectedArray = [
            'cards' => [
                ['suit' => 'Spades', 'rank' => '2'],
                ['suit' => 'Spades', 'rank' => '3'],
                ['suit' => 'Spades', 'rank' => '4'],
                ['suit' => 'Spades', 'rank' => '5'],
                ['suit' => 'Spades', 'rank' => '6'],
                ['suit' => 'Spades', 'rank' => '7'],
                ['suit' => 'Spades', 'rank' => '8'],
                ['suit' => 'Spades', 'rank' => '9'],
                ['suit' => 'Spades', 'rank' => '10'],
                ['suit' => 'Spades', 'rank' => 'Jack'],
                ['suit' => 'Spades', 'rank' => 'Queen'],
                ['suit' => 'Spades', 'rank' => 'King'],
                ['suit' => 'Spades', 'rank' => 'Ace'],
                ['suit' => 'Hearts', 'rank' => '2'],
                ['suit' => 'Hearts', 'rank' => '3'],
                ['suit' => 'Hearts', 'rank' => '4'],
                ['suit' => 'Hearts', 'rank' => '5'],
                ['suit' => 'Hearts', 'rank' => '6'],
                ['suit' => 'Hearts', 'rank' => '7'],
                ['suit' => 'Hearts', 'rank' => '8'],
                ['suit' => 'Hearts', 'rank' => '9'],
                ['suit' => 'Hearts', 'rank' => '10'],
                ['suit' => 'Hearts', 'rank' => 'Jack'],
                ['suit' => 'Hearts', 'rank' => 'Queen'],
                ['suit' => 'Hearts', 'rank' => 'King'],
                ['suit' => 'Hearts', 'rank' => 'Ace'],
                ['suit' => 'Diamonds', 'rank' => '2'],
                ['suit' => 'Diamonds', 'rank' => '3'],
                ['suit' => 'Diamonds', 'rank' => '4'],
                ['suit' => 'Diamonds', 'rank' => '5'],
                ['suit' => 'Diamonds', 'rank' => '6'],
                ['suit' => 'Diamonds', 'rank' => '7'],
                ['suit' => 'Diamonds', 'rank' => '8'],
                ['suit' => 'Diamonds', 'rank' => '9'],
                ['suit' => 'Diamonds', 'rank' => '10'],
                ['suit' => 'Diamonds', 'rank' => 'Jack'],
                ['suit' => 'Diamonds', 'rank' => 'Queen'],
                ['suit' => 'Diamonds', 'rank' => 'King'],
                ['suit' => 'Diamonds', 'rank' => 'Ace'],
                ['suit' => 'Clubs', 'rank' => '2'],
                ['suit' => 'Clubs', 'rank' => '3'],
                ['suit' => 'Clubs', 'rank' => '4'],
                ['suit' => 'Clubs', 'rank' => '5'],
                ['suit' => 'Clubs', 'rank' => '6'],
                ['suit' => 'Clubs', 'rank' => '7'],
                ['suit' => 'Clubs', 'rank' => '8'],
                ['suit' => 'Clubs', 'rank' => '9'],
                ['suit' => 'Clubs', 'rank' => '10'],
                ['suit' => 'Clubs', 'rank' => 'Jack'],
                ['suit' => 'Clubs', 'rank' => 'Queen'],
                ['suit' => 'Clubs', 'rank' => 'King'],
                ['suit' => 'Clubs', 'rank' => 'Ace']
            ]
        ];

        // Convert the expected array to JSON
        $expectedJson = json_encode($expectedArray);
        
        // Serialize the CardHand instance
        $serializedArray = $deck->jsonSerialize();
        $actualJson = json_encode($serializedArray);

        if ($expectedJson === false) {
            $this->fail('json_encode failed for expected JSON');
        }

        if ($actualJson === false) {
            $this->fail('json_encode failed for gameService');
        }

        // Assert that the serialized JSON matches the expected JSON
        $this->assertJsonStringEqualsJsonString($expectedJson, $actualJson, 'JSON serialization of CardHand does not match expected format');
    }
}