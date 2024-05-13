<?php

namespace App\Cardgame;

/**
 * Represents a playing card.
 */
class Card
{
    private $suit;
    private $rank;

    /**
     * Constructor.
     *
     * @param string $rank The rank of the card.
     * @param string $suit The suit of the card.
     */
    public function __construct($suit, $rank, $value)
    {
        $this->suit = $suit;
        $this->rank = $rank;
    }

    /**
     * Get the rank of the card.
     *
     * @return string The rank of the card.
     */
    public function getRank()
    {
        return $this->rank;
    }

    /**
     * Set the rank of the card.
     *
     * @param string $rank The rank of the card.
     */
    public function setRank($rank)
    {
        $this->rank = $rank;
    }

    /**
     * Get the suit of the card.
     *
     * @return string The suit of the card.
     */
    public function getSuit()
    {
        return $this->suit;
    }

    /**
     * Set the suit of the card.
     *
     * @param string $suit The suit of the card.
     */
    public function setSuit($suit)
    {
        $this->suit = $suit;
    }

    /**
     * Get a string representation of the card.
     *
     * @return string The string representation of the card.
     */
    public function displayCard()
    {
        $cardName = $this->rank . ' of ' . $this->suit;
        return $cardName;
    }

}
