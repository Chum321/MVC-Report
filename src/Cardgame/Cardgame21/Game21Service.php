<?php

namespace App\Cardgame\Cardgame21;

use App\Cardgame\DeckOfCards;
use App\Cardgame\CardHand;

class Game21Service
{
    private DeckOfCards $deck;
    private array $players;
    private CardHand $bank;

    /**
     * 
     * 
     * 
     * 
    */
    public function __construct(DeckOfCards $deck)
    {
        $this->deck = $deck;
        $this->deck->shuffle();
        $this->players = [];
        $this->bank = new CardHand();
    }

    /**
     * 
     * 
     * 
     * 
    */
    public function initializeGame(int $numPlayers): void
    {
        // Clear the players array before initializing
        $this->players = [];
        // Adds players "cardhands" to the players array
        for ($i = 0; $i < $numPlayers; $i++) {
            $this->players[] = new CardHand();
        }
        $this->bank = new CardHand();
    }

    /**
     * 
     * 
     * 
     * 
    */
    public function dealCardToPlayer(int $playerIndex): ?Card
    {
        return $this->players[$playerIndex]->drawCardFromDeck($this->deck);
    }

    /**
     * 
     * 
     * 
     * 
    */
    public function dealCardToBank(): ?Card
    {
        return $this->bank->drawCardFromDeck($this->deck);
    }

    /**
     * 
     * 
     * 
     * 
    */
    public function getPlayerCards(int $playerIndex): array
    {
        return $this->players[$playerIndex]->getCards();
    }

    /**
     * 
     * 
     * 
     * 
    */
    public function getBankCards(): array
    {
        return $this->bank->getCards();
    }
}