<?php

namespace App\Cardgame;

class CardGraphic extends Card
{
    private const SUIT_SYMBOLS = [
        'Spades' => '♠',
        'Hearts' => '♥',
        'Diamonds' => '♦',
        'Clubs' => '♣'
    ];

    private const RANK_SYMBOLS = [
        '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7', '8' => '8', '9' => '9', '10' => '10',
        'Jack' => 'J', 'Queen' => 'Q', 'King' => 'K', 'Ace' => 'A'
    ];

    public function getGraphic(): string
    {
        $suit = $this->getSuit();
        $rank = $this->getRank();

        $suitSymbol = self::SUIT_SYMBOLS[$suit] ?? '';
        $rankSymbol = self::RANK_SYMBOLS[$rank] ?? '';

        return $rankSymbol . $suitSymbol;
    }

    public function __toString(): string
    {
        return $this->getGraphic();
    }
}
