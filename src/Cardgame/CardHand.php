<?php

namespace App\Cardgame;

/**
 * represents a hand of cards.
 *
 *
 */
class CardHand
{
    private array $cards = [];

    /**
     * adds a given card object to the hand.
     *
     *
     */
    public function addCard(Card $card): void
    {
        $this->cards[] = $card;
    }

    /**
     * retrives the cards from a DeckOfCards object.
     *
     *
     */
    public function getCards(): array
    {
        return $this->cards;
    }

    /**
     *
     *
     *
     */
    public function drawCardFromDeck(DeckOfCards $deck): ?Card
    {
        $cards = $deck->getCards();

        if (empty($cards)) {
            return null; // Deck is empty
        }

        // Draw a card from the deck
        $card = array_pop($cards);

        // Update the deck's cards
        $deck->setCards($cards);

        // Add the drawn card to the hand
        $this->addCard($card);

        return $card;
    }
}
