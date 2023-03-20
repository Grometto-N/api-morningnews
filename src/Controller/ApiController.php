<?php

namespace App\Controller;

use App\Services\CallApiExterneService;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{   
    #[Route('/morningnews/articles', name: 'app_api_articles',methods: ['GET'])]
    public function index(CallApiExterneService $callApiService): JsonResponse
    {   
        $dataArticles = $callApiService->getData();

        $datasToSend = [];

        if($dataArticles["status"] === "ok"){
            foreach($dataArticles['articles'] as $article){
                $theArticle=[
                    "title" => $article["title"],
                    "author" => $article["author"],
                    "description" => $article["description"],
                    "urlToImage" => $article["urlToImage"]
                    ];
                $datasToSend[]=$theArticle;    
            }

            return new JsonResponse(["result" => true,
                                    "articles" =>  $datasToSend
                                ]);
        }                       

        return new JsonResponse(["result" => false,
                                "articles" =>  $datasToSend
                                ]);
    }

    #[Route('/morningnews/canBookmark', name: 'app_api_canBookmark',methods: ['GET'])]
    public function canBookmark(): JsonResponse
    { 
        // on considère que tous les utilisateurs inscrits peuvent avoir des favoris 
        return new JsonResponse(["result" => true]);
    }
}
