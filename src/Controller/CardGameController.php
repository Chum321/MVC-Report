<?php

namespace App\Controller;

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
        $currentYear = date('Y');
        return $this->render('card/card_deck.html.twig', [
            'currentYear' => $currentYear,
        ]);
    }

    #[Route("/card/deck/shuffle", name: "shuffle_page")]
    public function shuffle(): Response
    {
        $currentYear = date('Y');
        return $this->render('card/card_shuffle.html.twig', [
            'currentYear' => $currentYear,
        ]);
    }

    #[Route("/card/deck/draw", name: "draw_page")]
    public function draw(): Response
    {
        $currentYear = date('Y');
        return $this->render('card/card_draw.html.twig', [
            'currentYear' => $currentYear,
        ]);
    }
}
