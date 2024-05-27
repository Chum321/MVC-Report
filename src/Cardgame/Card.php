<?php

namespace App\Cardgame;

/**
 * Represents a playing card.
 */
class Card implements \JsonSerializable
{
    private string $suit;
    private string $rank;

    /**
     * Constructor.
     *
     * @param string $rank The rank of the card.
     * @param string $suit The suit of the card.
     */
    public function __construct($suit, $rank)
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
    public function setRank($rank): void
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
    public function setSuit($suit): void
    {
        $this->suit = $suit;
    }

    /**
     * Get a string representation of the card.
     *
     * @return string The string representation of the card.
     */
    public function __toString(): string
    {
        return $this->rank . ' of ' . $this->suit;
    }

    public function jsonSerialize()
    {
        return [
            'suit' => $this->suit,
            'rank' => $this->rank,
        ];
    }

}
