<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class LuckyControllerJson
{
    #[Route("/api/lucky/number", name: "api_lucky_numbers")]
    public function jsonNumber(): JsonResponse
    {
        $number = random_int(0, 100);

        $data = [
            'lucky-number' => $number,
            'lucky-message' => 'Hi there!',
        ];

        // return new JsonResponse($data);

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    #[Route("/api/quote", name: "api_quote")]
    public function apiQuote(): JsonResponse
    {
        $quotes = [
            "The only way to do great work is to love what you do. - Steve Jobs",
            "In the midst of chaos, there is also opportunity. - Sun Tzu",
            "These quotes was not taken from chatgpt 3.5, totes not."
        ];

        // Selects a random quote
        $randomQuote = $quotes[array_rand($quotes)];

        $date = date("Y-m-d");
        $timestamp = time();

        $response = new JsonResponse([
            'quote' => $randomQuote,
            'date' => $date,
            'timestamp' => $timestamp
        ]);

        return $response;
    }
}
