<?php

namespace App\Controller;

use App\Services\CallApiExterneService;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{   
    #[Route('/api/articles', name: 'app_api_articles')]
    public function index(CallApiExterneService $callApiService): JsonResponse
    {   
        $dataArticles = $callApiService->getData();
        // dd($dataArticles["status"]);
        // dd($dataArticles['articles'][0]);
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
}
