<?php

namespace App\Services;

use Symfony\Contracts\HttpClient\HttpClientInterface;



class CallApiExterneService
{
    private HttpClientInterface $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function getData():array
    {   
        $apiKey = $_ENV['API_KEY'];
        try {
            $response = $this->client->request(
                'GET',
                'https://newsapi.org/v2/top-headlines?sources=the-verge&apiKey='.$apiKey
            );
        } catch (\Exception $e) {
            
        }

        return $response->toArray();
    }
}