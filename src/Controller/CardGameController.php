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
        $currentYear = date('Y');
        return $this->render('card_landingpage.html.twig', [
            'currentYear' => $currentYear,
        ]);
    }
}
