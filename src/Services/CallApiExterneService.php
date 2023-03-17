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
        $datas = array();
        try {
            $response = $this->client->request(
                'GET',

            );
            $datas = $response->toArray();
        } catch (\Exception $e) {
            
        }
       
        return new JsonResponse($response->getContent(), $response->getStatusCode(), [], true);
        // return $datas;
    }
}