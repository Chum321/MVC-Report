<?php

namespace App\Cardgame;

use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Cardgame\DeckOfCards;

class SessionDeckOfCards extends DeckOfCards
{
    private const SESSION_KEY = 'session_deck_of_cards';
    // private array $cards = [];

    public function __construct(array $cards = [])
    {
        parent::__construct($cards);
    }

    public function saveToSession(SessionInterface $session): void
    {
        $session->set(self::SESSION_KEY, serialize($this->cards));
    }

    public static function loadFromSession(SessionInterface $session): ?self
    {
        $cards = $session->get(self::SESSION_KEY);

        if (!$cards) {
            return null;
        }

        $deck = new self();
        $deck->cards = unserialize($cards);

        return $deck;
    }
}
