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
        $dataCity = $callApiService->getData("Villeurbanne");
        // dd($dataCity);
        return $dataCity;

        // return $this->json([
        //     'message' => 'Welcome to your new controller!',
        //     'path' => 'src/Controller/ApiPostController.php',
        // ]);
    }
}
