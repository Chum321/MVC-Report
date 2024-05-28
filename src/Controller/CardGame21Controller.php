<?php
// src/Controller/CardGame21Controller.php
namespace App\Controller;

use App\Service\GameService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CardGame21Controller extends AbstractController
{

    #[Route("/game", name: "game_landingpage")]
    public function cardgame21(): Response
    {
        $currentYear = date('Y');
        return $this->render('card/cardgame21/card_game_21.html.twig', [
            'currentYear' => $currentYear,
        ]);
    }

    #[Route("/game/play", name: "game_play")]
    public function cardgameplay(): Response
    {
        $currentYear = date('Y');
        return $this->render('card/cardgame21/card_game_play.html.twig', [
            'currentYear' => $currentYear,
        ]);
    }

}
