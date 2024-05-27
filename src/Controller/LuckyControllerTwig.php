<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use ReflectionMethod;

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

    #[Route("/api/", name: "api_landing")]
    public function apiLanding(RouterInterface $router): Response
    {
        $currentYear = date('Y');

        // Get all routes
        $routes = $router->getRouteCollection()->all();

        // Filter JSON routes
        $jsonRoutes = [];

        foreach ($routes as $name => $route) {
            // Check if the route path starts with '/api/'
            if (strpos($route->getPath(), '/api/') === 0 && $this->isJsonRoute($route)) {
                // Replace dynamic parameters with sample values
                $path = preg_replace('/\{\w+\}/', '5', $route->getPath());
                $jsonRoutes[] = [
                    'name' => $name,
                    'path' => $path,
                ];
            }
        }

        // Define explanations for each route
        $explanations = [
            'Opening this route returns a deck of cards in a sorted format (does not save to session)',
            'Shuffle does the same thing as api_deck except it is shuffled and saves to the session',
            'This page returns a json representation of a had with a card drawn and the remaining deck. the changes to the deck is saved to the session',
            'Does the same as api_deck_draw except it also requires a /num to be appended to the url. Allowing the user to chose the number of cards drawn.',
            'Returns a lucky number randomized between 1-100 and a message',
            'Returns a random quote from a set list and the current date with a timestamp',
        ];

        return $this->render('landingpage.html.twig', [
            'jsonRoutes' => $jsonRoutes,
            'explanations' => $explanations,
            'currentYear' => $currentYear,
        ]);
    }

    private function isJsonRoute($route): bool
    {
        $controller = $route->getDefault('_controller');
        if (is_string($controller) && strpos($controller, '::') !== false) {
            [$controllerClass, $controllerMethod] = explode('::', $controller);
            $reflectionMethod = new ReflectionMethod($controllerClass, $controllerMethod);
            $returnType = $reflectionMethod->getReturnType();
            return $returnType && $returnType->getName() === JsonResponse::class;
        }
        return false;
    }

}
