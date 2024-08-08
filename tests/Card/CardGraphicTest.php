<?php

namespace App\Cardgame;

use PHPUnit\Framework\TestCase;

/**
 * A class containing a collection of tests for the CardGraphic class
 */
class CardGraphicTest extends TestCase
{
    /**
     * Construct object and verify that the object is a object, use no arguments.
     */
    public function testCreateCardGraphic(): void
    {
        $suit = 'Spades';
        $rank = 'Ace';
        $card = new CardGraphic($suit, $rank);
        $this->assertIsObject($card);
    }

    /**
     * Construct object and verify that the getGraphic method works as expected.
     */
    public function testGetGraphic(): void
    {
        $suit = 'Spades';
        $rank = 'Ace';
        $card = new CardGraphic($suit, $rank);

        $res = $card->getGraphic();

        $this->assertIsString($res);
        $this->assertEquals('A♠',$res);
    }

    /**
     * Construct object and verify that the __toString method works as expected.
     */
    public function testToString(): void
    {
        $suit = 'Spades';
        $rank = 'Ace';
        $card = new CardGraphic($suit, $rank);

        $res = $card->__toString();

        $this->assertIsString($res);
        $this->assertEquals('A♠',$res);
    }

    /**
     * Construct object and verify that the graphic method works as expected.
     */
    public function testgraphic(): void
    {
        $suit = 'Spades';
        $rank = 'Ace';
        $card = new CardGraphic($suit, $rank);

        $res = $card->graphic();

        $this->assertIsString($res);
        $this->assertEquals('spades-ace',$res);
    }
}