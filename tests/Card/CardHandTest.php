<?php

namespace App\Cardgame;

use PHPUnit\Framework\TestCase;

/**
 * A class containing a collection of tests for the CardHand class
 */
class CardHandTest extends TestCase
{
    /**
     *
     *
     */
    public function testAddAndGetCard()
    {
        $suit = 'Spades';
        $rank = 'Ace';
        $card = new Card($suit, $rank);
        $hand = new CardHand();

        $this->assertEmpty($hand->getCards(), 'Hand should be empty initially');

        $hand->addCard($card);
        $cards = $hand->getCards();

        $this->assertNotEmpty($cards, 'Hand should not be empty after adding a card');
        $this->assertCount(1, $cards, 'Hand should contain exactly one card');
        $this->assertSame($card, $cards[0], 'The card in the deck should be the one that was added');
    }

    /**
     *
     *
     */
    public function testDrawCardFromDeck()
    {
        $suit = 'Spades';
        $rank = 'Ace';
        $card = new Card($suit, $rank);
        $hand = new CardHand();
        $drawnCards = [];

        $hand->addCard($card);

        $deck = new DeckOfCards();

        $arrayOfCards = $deck->getCards();

        foreach ($arrayOfCards as $card){
            $drawnCards = $hand->drawCardFromDeck($deck);
        }

        $arrayOfNullCards = $deck->getCards();

        $this->assertIsObject($deck);
        $this->assertCount(52, $arrayOfCards);
        $this->assertCount(0, $arrayOfNullCards);
        $res = $hand->drawCardFromDeck($deck);
        $this->assertNull($res);
    }

    public function testJsonSerialize()
    {
        // Create sample cards
        $card1 = new Card('Hearts', 'Ace');
        $card2 = new Card('Diamonds', 'King');
        
        // Create a CardHand instance and add cards
        $hand = new CardHand();
        $hand->addCard($card1);
        $hand->addCard($card2);

        // Expected array format for jsonSerialize
        $expectedArray = [
            'cards' => [
                ['suit' => 'Hearts', 'rank' => 'Ace'],
                ['suit' => 'Diamonds', 'rank' => 'King']
            ]
        ];

        // Convert the expected array to JSON
        $expectedJson = json_encode($expectedArray);
        
        // Serialize the CardHand instance
        $serializedArray = $hand->jsonSerialize();
        $actualJson = json_encode($serializedArray);
        
        // Assert that the serialized JSON matches the expected JSON
        $this->assertJsonStringEqualsJsonString($expectedJson, $actualJson, 'JSON serialization of CardHand does not match expected format');
    }
}