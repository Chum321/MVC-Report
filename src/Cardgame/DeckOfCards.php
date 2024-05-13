<?php

namespace App\Cardgame;

/**
 * Represents a deck of cards
 *
 *
 */
class DeckOfCards
{
    private const SESSION_KEY = 'deck_of_cards';
    private array $cards = [];

    public function __construct()
    {
        $suits = ['Spades', 'Hearts', 'Diamonds', 'Clubs'];
        $ranks = ['2', '3', '4', '5', '6', '7', '8', '9', '10', 'Jack', 'Queen', 'King', 'Ace'];

        foreach ($suits as $suit) {
            foreach ($ranks as $rank) {
                $this->cards[] = new Card($suit, $rank);
            }
        }
    }

    /**
     * Shuffles the Cards of the Deck.
     *
     *
     */
    public function shuffle(): void
    {
        shuffle($this->cards);
    }

    /**
     * Get the Cards of the Deck.
     *
     * @return array The rank of the cards.
     */
    public function getCards(): array
    {
        return $this->cards;
    }

    /**
     * Set the Cards of the Deck.
     *
     *
     */
    public function setCards($newDeck): void
    {
        $this->cards = $newDeck;
    }
}
