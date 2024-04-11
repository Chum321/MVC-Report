<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LuckyControllerTwig extends AbstractController
{
    #[Route("/lucky/number/twig", name: "lucky_number")]
    public function number(): Response
    {
        $currentYear = date('Y');
        $number = random_int(0, 100);

        $data = [
            'number' => $number,
            'currentYear' => $currentYear,
        ];

        return $this->render('lucky_number.html.twig', $data);
    }

    #[Route("/home", name: "home")]
    public function home(): Response
    {
        $currentYear = date('Y');
        return $this->render('home.html.twig', [
            'currentYear' => $currentYear,
        ]);
    }

    #[Route("/about", name: "about")]
    public function about(): Response
    {
        $currentYear = date('Y');
        return $this->render('about.html.twig', [
            'currentYear' => $currentYear,
        ]);
    }

    #[Route("/report", name: "report")]
    public function report(): Response
    {
        $currentYear = date('Y');
        return $this->render('report.html.twig', [
            'currentYear' => $currentYear,
        ]);
    }

    #[Route("/", name: "homepage")]
    public function homepage(): Response
    {
        $currentYear = date('Y');
        return $this->render('index.html.twig', [
            'currentYear' => $currentYear,
        ]);
    }

    #[Route("/lucky", name: "lucky")]
    public function lucky(): Response
    {
        $luckyNumber = random_int(0, 100);
        $images = [
            'img/Sun.jpg',
            'img/Black-hole.jpg',
        ];
        $currentYear = date('Y');

        $randomImage = $images[array_rand($images)];

        return $this->render('lucky.html.twig', [
            'luckyNumber' => $luckyNumber,
            'randomImage' => $randomImage,
            'currentYear' => $currentYear,
        ]);
    }
}
