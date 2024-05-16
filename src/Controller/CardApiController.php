<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Cardgame\SessionDeckOfCards;
use App\Cardgame\CardHand;

class CardApiController extends AbstractController
{
    #[Route("/api/deck", name: "api_deck")]
    public function getDeck(SessionInterface $session): JsonResponse
    {

        $deck = new SessionDeckOfCards();

        $data = [
            'shuffled_deck' => $deck->getCards(),
            'message' => 'Deck has been returned and not saved to session.'
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    #[Route("/api/deck/shuffle", name: "api_deck_shuffle", methods: ["POST", "GET"])]
    public function shuffleDeck(Request $request, SessionInterface $session): JsonResponse
    {
        $deck = new SessionDeckOfCards();
        $deck->shuffle();
        $deck->saveToSession($session);

        $data = [
            'shuffled_deck' => $deck->getCards(),
            'message' => 'Deck has been shuffled and saved to session.'
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    #[Route("/api/deck/draw", name: "api_deck_draw", methods: ["POST", "GET"])]
    public function drawCard(SessionInterface $session, Request $request): JsonResponse
    {
        $deck = SessionDeckOfCards::loadFromSession($request->getSession());

        if (!$deck) {
            $deck = new SessionDeckOfCards();
        }

        $hand = new CardHand();

        $numCardsToDraw = 1; // Set the number of cards to draw

        for ($i = 0; $i < $numCardsToDraw; $i++) {
            $hand->drawCardFromDeck($deck); // draws cards from the deck
        }

        // Save the updated deck to the session
        $deck->saveToSession($request->getSession());

        $data = [
            'hand_Cards' => $hand->getCards(),
            'shuffled_deck' => $deck->getCards(),
            'message' => 'Card has been drawn and deck has been saved to session'
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    #[Route("/api/deck/draw/{numCardsToDraw<\d+>}", name: "api_deck_draw_number", methods: ["POST", "GET"])]
    public function drawCards(SessionInterface $session, int $numCardsToDraw, Request $request): JsonResponse
    {
        $deck = SessionDeckOfCards::loadFromSession($request->getSession());

        if (!$deck) {
            $deck = new SessionDeckOfCards();
        }

        $hand = new CardHand();

        for ($i = 0; $i < $numCardsToDraw; $i++) {
            $hand->drawCardFromDeck($deck); // draws cards from the deck
        }

        // Save the updated deck to the session
        $deck->saveToSession($request->getSession());

        $data = [
            'hand_Cards' => $hand->getCards(),
            'shuffled_deck' => $deck->getCards(),
            'message' => 'Card has been drawn and deck has been saved to session'
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }
}
