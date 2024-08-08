<?php

namespace App\Cardgame;

use PHPUnit\Framework\TestCase;

/**
 * A class containing a collection of tests for the Card class
 */
class CardTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties, use necessary arguments.
     */
    public function testCreateCard(): void
    {
        $suit = 'Spades';
        $rank = 'Ace';
        $card = new Card($suit, $rank);

        $this->assertIsObject($card);
        $this->assertObjectHasProperty('suit', $card, $message = 'Card does not have suit');
        $this->assertObjectHasProperty('rank', $card, $message = 'Card does not have rank');
    }

    /**
     * Cunstruct object and verify that the getter and setter for rank works as expected
     * properties, use both arguments.
     */
    public function testRank(): void
    {
        $suit = 'Spades';
        $rank = 'Ace';
        $card = new Card($suit, $rank);

        $res1 = $card->getRank();

        $card->setRank('2');
        $res2 = $card->getRank();

        $this->assertEquals('Ace', $res1);
        $this->assertEquals('2', $res2);
    }

    /**
     * Cunstruct object and verify that the getter and setter for Suit works as expected
     * properties, use both arguments.
     */
    public function testSuit(): void
    {
        $suit = 'Spades';
        $rank = 'Ace';
        $card = new Card($suit, $rank);

        $res1 = $card->getSuit();

        $card->setSuit('Hearts');
        $res2 = $card->getSuit();

        $this->assertEquals('Spades', $res1);
        $this->assertEquals('Hearts', $res2);
    }

    /**
     * Cunstruct object and verify that the toString works as expected
     * properties, use both arguments.
     */
    public function testToString(): void
    {
        $suit = 'Spades';
        $rank = 'Ace';
        $card = new Card($suit, $rank);

        $res = $card->__toString();

        $this->assertEquals('Ace of Spades', $res);
    }

    /**
     * Cunstruct object and verify that the jsonSerialize works as expected
     * properties, use both arguments.
     */
    public function testJsonSerialize(): void
    {
        $suit = 'Spades';
        $rank = 'Ace';
        $card = new Card($suit, $rank);

        $json = json_encode($card->jsonSerialize());
        $expectedJson = json_encode([
            'suit' => 'Spades',
            'rank' => 'Ace',
        ]);

        $res = $card->jsonSerialize();

        if ($json === false) {
            $this->fail('json_encode failed for gameService');
        }

        if ($expectedJson === false) {
            $this->fail('json_encode failed for gameService');
        }

        $this->assertJsonStringEqualsJsonString($expectedJson, $json, 'Card JSON serialization is incorrect');
    }
}