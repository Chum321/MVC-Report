<?php
// src/Controller/CardGame21Controller.php
namespace App\Controller;

use App\Cardgame\Cardgame21\Game21Service;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CardGame21Controller extends AbstractController
{
    private Game21Service $gameService;

    public function __construct(Game21Service $gameService)
    {
        $this->gameService = $gameService;
    }

    #[Route("/game", name: "game_landingpage")]
    public function cardgame21(): Response
    {
        $currentYear = date('Y');
        return $this->render('card/cardgame21/card_game_21.html.twig', [
            'currentYear' => $currentYear,
        ]);
    }

    #[Route('/game/start', name: 'game_start')]
    public function start(SessionInterface $session, Request $request): Response
    {
        $numPlayers = (int) $request->query->get('players', 5); // Default to 1 player if not specified
        $this->gameService->initializeGame($numPlayers);

        $session->set('gameService', $this->gameService);
        // $session->set('currentPlayer', 0); // Initialize current player index

        return $this->redirectToRoute('game_play');
    }

    #[Route('/game/play', name: 'game_play')]
    public function play(SessionInterface $session): Response
    {
        $currentYear = date('Y');

        /** @var Game21Service $gameService */
        $gameService = $session->get('gameService');

        // Check if the game is finished
        if ($gameService->currentPlayer() >= $gameService->getPlayerCount()) {
            $gameService->finishGame();
        }

        return $this->render('card/cardgame21/play.html.twig', [
            'currentYear' => $currentYear,
            'players' => $gameService->getPlayers(),
            'bank' => $gameService->getBankCards(),
            'cards' => $gameService->getDeck()->getCards(),
            'handValues' => $gameService->calculatePlayersHandValue(),
            'bankValue' => $gameService->calculateBankHandValue(),
            'currentPlayer' => $gameService->currentPlayer(),
            'gameFinished' => $gameService->isGameFinished(),
            'cardsDealtBool' => $gameService->cardsDealt(),
        ]);
    }

    // EXPERIMENTAL

    // #[Route('/game/draw/{player}', name: 'game_draw_card')]
    // public function drawCard(SessionInterface $session, int $player): Response
    // {
        
    //     $gameService = $session->get('gameService');
    //     $gameService->dealCardToPlayer($player);

    //     $session->set('gameService', $gameService);

    //     return $this->redirectToRoute('game_play');
    // }

    #[Route('/game/dealing', name: 'game_deal_card')]
    public function drawDeal(SessionInterface $session): Response
    {
        /** @var Game21Service $gameService */
        $gameService = $session->get('gameService');

        $cardsDealtBool = $gameService->cardsDealt();

        if ($cardsDealtBool['firstRoundDraw'] === false) {
            $gameService->drawFirstRound();
        } elseif ($cardsDealtBool['secondRoundDraw'] === false) {
            $gameService->drawSecondRound();
        }

        // Update the session
        $session->set('gameService', $gameService);

        return $this->redirectToRoute('game_play');
    }


    #[Route('/game/draw', name: 'game_draw_card')]
    public function drawCard(SessionInterface $session): Response
    {
        /** @var Game21Service $gameService */
        $gameService = $session->get('gameService');

        // Draw a card for the current player
        $gameService->dealCardToPlayer($gameService->currentPlayer());

        // Gets the players
        $playerArray = $gameService->getPlayers($gameService->currentPlayer());

        $allHandValues = $gameService->calculatePlayersHandValue();

        // Gets the hand value for current player
        $handValue = $allHandValues[$gameService->currentPlayer()];

        // If hand value is 21 or more, auto stand the player's turn
        if ($handValue >= 21) {
            // Update the session
            $session->set('gameService', $gameService);
            return $this->redirectToRoute('game_stand');
        }

        // Update the session
        $session->set('gameService', $gameService);

        return $this->redirectToRoute('game_play');
    }

    #[Route('/game/stand', name: 'game_stand')]
    public function stand(SessionInterface $session): Response
    {
        /** @var Game21Service $gameService */
        $gameService = $session->get('gameService');
        $currentPlayer = $gameService->nextPlayer();

        // Update the session
        $session->set('gameService', $gameService);

        return $this->redirectToRoute('game_play');
    }

    #[Route('/game/finished', name: 'game_done_screen')]
    public function finished(SessionInterface $session): Response
    {
        $currentYear = date('Y');
        /** @var Game21Service $gameService */
        $gameService = $session->get('gameService');

        return $this->render('card/cardgame21/finished.html.twig', [
            'currentYear' => $currentYear,
            'players' => $gameService->getPlayers(),
            'bank' => $gameService->getBankCards(),
            'cards' => $gameService->getDeck()->getCards(),
            'handValues' => $gameService->calculatePlayersHandValue(),
            'bankValue' => $gameService->calculateBankHandValue(),
            'currentPlayer' => $gameService->currentPlayer(),
            'gameFinished' => $gameService->isGameFinished(),
            'results' => $gameService->determineWinners(),
        ]);
    }

    #[Route('/game/result', name: 'game_result')]
    public function result(SessionInterface $session): Response
    {
        $currentYear = date('Y');

        /** @var Game21Service $gameService */
        $gameService = $session->get('gameService');

        $result = $gameService->determineWinner();

        return $this->render('card/cardgame21/result.html.twig', [
            'currentYear' => $currentYear,
            'players' => $gameService->getPlayers(),
            'bank' => $gameService->getBankCards(),
            'result' => $result,
        ]);
    }

    #[Route('/game/reset', name: 'game_reset')]
    public function reset(SessionInterface $session): Response
    {
        $session->remove('gameService');

        return $this->redirectToRoute('game_landingpage');
    }

    #[Route('/game/double_down', name: 'game_double_down')]
    public function doubledown(SessionInterface $session): Response
    {
        $session->remove('gameService');

        return $this->redirectToRoute('game_landingpage');
    }

    

}
