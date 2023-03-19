<?php

namespace App\Services;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpFoundation\JsonResponse;



class CallApiExterneService
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function getData(string $city):JsonResponse
    {   
        $apiKey = $_ENV['API_KEY'];
        try {
            $response = $this->client->request(
                'GET',
                'https://newsapi.org/v2/top-headlines?sources=the-verge&apiKey='.$apiKey
            );
        } catch (\Exception $e) {
            
        }
        return new JsonResponse($response->getContent(), $response->getStatusCode(), [], true);

    }
}