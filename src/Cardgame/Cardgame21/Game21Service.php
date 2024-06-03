<?php

namespace App\Cardgame\Cardgame21;

use App\Cardgame\DeckOfCards;
use App\Cardgame\Card;
use App\Cardgame\CardHand;
use App\Cardgame\CardGraphic;

class Game21Service
{
    private DeckOfCards $deck;
    private array $players;
    private CardHand $bank;
    private int $currentPlayer = 0;
    private int $numPlayers;
    private bool $bankHasPlayed = false;
    private bool $gameFinished = false;

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
        // Create and shuffle the deck
        $this->deck = new DeckOfCards();
        $this->deck->shuffle();

        // Clear the players array before initializing
        $this->players = [];
        // Adds players "cardhands" to the players array
        for ($i = 0; $i < $numPlayers; $i++) {
            $this->players[] = new CardHand();
        }
        $this->bank = new CardHand();

        $this->numPlayers = count($this->players);

        // Deal the starting cards to players and the bank
        $this->dealStartingCards();
    }

    /**
     * 
     * 
     * 
     * 
    */
    private function dealStartingCards(): void
    {
        // Deal the first card to each player and the bank
        foreach ($this->players as $player) {
            $player->drawCardFromDeck($this->deck);
        }
        $this->bank->drawCardFromDeck($this->deck);

        // Deal the second card to each player and the bank
        foreach ($this->players as $player) {
            $player->drawCardFromDeck($this->deck);
        }
        // $this->bank->addCard($this->deck->drawCard());
    }

    /**
     * 
     * 
     * 
     * 
    */
    public function dealCardToPlayer(int $playerIndex): ?Card
    {
        // Calculate the current hand value of the player
        $playerHandValue = $this->calculateHandValue($this->players[$playerIndex]);

        if ($playerHandValue >= 21){
            return null;
        }
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

    /**
     * 
     * 
     * 
     * 
    */
    public function getPlayers(): array
    {
        return $this->players;
    }

    /**
     * 
     * 
     * 
     * 
    */
    public function getPlayer(int $playerIndex): array
    {
        return $this->players[$playerIndex];
    }

    /**
     * 
     * 
     * 
     * 
    */
    public function getDeck(): DeckOfCards
    {
        return $this->deck;
    }

    /**
     * gets current player variable value
     * 
     * 
     * 
    */
    public function currentPlayer(): int
    {
        return $this->currentPlayer;
    }

    /**
     * increments current player variable by 1
     * 
     * 
     * 
    */
    public function nextPlayer(): int
    {
        // Increment the current player
        $this->currentPlayer++;

        // Check if the current player exceeds the number of players
        if ($this->currentPlayer >= $this->numPlayers) {
            $this->dealerTurn();
        }

        return $this->currentPlayer;
    }

    /**
     * Calculates the value of a card
     * 
     * 
     * 
    */
    public function calculateCardValue(Card $card): int
    {
        switch ($card->getRank()) {
            case 'Jack':
            case 'Queen':
            case 'King':
                return 10;
            case 'Ace':
                return 11; // Aces are handled separately in calculateHandValue
            default:
                return intval($card->getRank());
        }
    }

    /**
     * Calculates the value of a hand of cards
     * 
     * 
     * 
    */
    public function calculateHandValue(CardHand $hand): int
    {
        $cards = $hand->getCards();
        $totalValue = 0;
        $aceCount = 0;

        foreach ($cards as $card) {
            $value = $this->calculateCardValue($card);
            $totalValue += $value;

            if ($card->getRank() === 'Ace') {
                $aceCount++;
            }
        }

        while ($totalValue > 21 && $aceCount > 0) {
            $totalValue -= 10;
            $aceCount--;
        }

        return $totalValue;
    }

    public function calculatePlayersHandValue(): array
    {
        $handValues = [];

        foreach ($this->players as $index => $player) {
            $handValues[$index] = $this->calculateHandValue($player);
        }

        return $handValues;
    }

    public function calculateBankHandValue(): int
    {
        $banksHandValue = $this->calculateHandValue($this->bank);

        return $banksHandValue;
    }

    public function dealerTurn(): void
    {
        while ($this->calculateHandValue($this->bank) < 17) {
            $this->dealCardToBank();
        }
        $this->bankHasPlayed = true;
    }

    public function determineWinners(): array
    {
        $results = [];
        $bankValue = $this->calculateHandValue($this->bank);

        foreach ($this->players as $index => $player) {
            $playerValue = $this->calculateHandValue($player);
            if ($playerValue > 21) {
                $results[$index] = 'Bust';
            } elseif ($bankValue > 21 || $playerValue > $bankValue) {
                $results[$index] = 'Win';
            } elseif ($playerValue < $bankValue) {
                $results[$index] = 'Lose';
            } else {
                $results[$index] = 'Tie';
            }
        }

        return $results;
    }

    public function isGameFinished(): bool
    {
        return $this->gameFinished;
    }

    public function finishGame(): void
    {
        $this->gameFinished = true;
    }

    public function getPlayerCount(): int
    {
        return $this->numPlayers;
    }
}