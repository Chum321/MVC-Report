<?php

namespace App\Controller;

use App\Cardgame\DeckOfCards;
use App\Cardgame\CardHand;
use App\Cardgame\SessionDeckOfCards;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;




use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Request;

class CardGameController extends AbstractController
{
    #[Route("/card", name: "card_landingpage")]
    public function landingPage(): Response
    {

        // Check if session exists
        //code provided by chatgpt for starting session if it is not on, stored here on temp basis
        // if (!$session->isStarted()) {
            // Start the session
        //     $session->start();
        // }

        $currentYear = date('Y');
        return $this->render('card/card_landingpage.html.twig', [
            'currentYear' => $currentYear,
        ]);
    }

    #[Route("/card/deck", name: "deck_page")]
    public function deck(): Response
    {
        $deck = new DeckOfCards();
        $cards = $deck->getCards();

        
        $currentYear = date('Y');
        return $this->render('card/card_deck.html.twig', [
            'currentYear' => $currentYear,
            'cards' => $cards,
        ]);
    }

    #[Route("/card/deck/shuffle", name: "shuffle_page")]
    public function shuffle(Request $request, SessionDeckOfCards $deck): Response
    {
        $currentYear = date('Y');

        
        // $deck = new DeckOfCards();
        $deck->shuffle();
        // Save the shuffled deck to the session
        $deck->saveToSession($request->getSession());
        $shuffledCards = $deck->getCards();
        
        return $this->render('card/card_shuffle.html.twig', [
            'currentYear' => $currentYear,
            'shuffledCards' => $shuffledCards,
        ]);
    }
    
    #[Route("/card/deck/draw", name: "draw_page")]
    public function draw(Request $request): Response
    {
        $currentYear = date('Y');

        $deck = SessionDeckOfCards::loadFromSession($request->getSession());

        if (!$deck) {
            $deck = new SessionDeckOfCards();
        }
        // $deck = SessionDeckOfCards::loadFromSession($request->getSession());

        $hand = new CardHand();
        // $deck = new DeckOfCards();
        // $deck->shuffle();

        
        $numCardsToDraw = 1; // Set the number of cards to draw
        
        for ($i = 0; $i < $numCardsToDraw; $i++) {
            $hand->drawCardFromDeck($deck); // draws cards from the deck
        }

        $shuffledDeck = $deck->getCards();
        $handCards = $hand->getCards();
        // Save the updated deck to the session
        $deck->saveToSession($request->getSession());

        return $this->render('card/card_draw.html.twig', [
            'currentYear' => $currentYear,
            'handCards' => $handCards,
            'shuffledDeck' => $shuffledDeck,
        ]);
    }

    #[Route("/card/deck/draw/{numCardsToDraw<\d+>}", name: "draw_page_number")]
    public function drawamount(Request $request, int $numCardsToDraw): Response
    {
        $currentYear = date('Y');

        $hand = new CardHand();
        // $deck = new DeckOfCards();
        // $deck->shuffle();
        $deck = SessionDeckOfCards::loadFromSession($request->getSession());

        if (!$deck) {
            $deck = new SessionDeckOfCards();
        }
        // $deck = SessionDeckOfCards::loadFromSession($request->getSession());
        
        for ($i = 0; $i < $numCardsToDraw; $i++) {
            $hand->drawCardFromDeck($deck); // draws cards from the deck
        }

        $shuffledDeck = $deck->getCards();
        $handCards = $hand->getCards();
        // Save the updated deck to the session
        $deck->saveToSession($request->getSession());

        return $this->render('card/card_draw.html.twig', [
            'currentYear' => $currentYear,
            'handCards' => $handCards,
            'shuffledDeck' => $shuffledDeck,
        ]);
    }
}
