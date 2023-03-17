<?php

namespace App\Controller;

use App\Services\CallApiExterneService;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ApiPostController extends AbstractController
{
    #[Route('/api/post', name: 'app_api_post')]
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
