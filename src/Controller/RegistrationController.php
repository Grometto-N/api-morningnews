<?php

namespace App\Controller;

use App\Entity\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;

class RegistrationController extends AbstractController
{
    #[Route('/morningnews/register', name: 'app_registration',methods: ['POST'])]
    public function index(Request $request, SerializerInterface $serializer, EntityManagerInterface  $manager, UserPasswordHasherInterface $userPasswordHasher, JWTTokenManagerInterface $JWTManager): JsonResponse
    {   

        // récuperation des données envoyés
        $data = $serializer->deserialize($request->getContent(),User::class, 'json');


        // recherche de l'utilisateur en BDD
       $user=$manager->getRepository(User::class)->findOneBy(
            ['username' => $data->getUsername()],
        );
        if($user !== null){
            return new JsonResponse(["result" => false, "error" => "User already exists"]);
        }
            

        // création d'un nouvel utilisateur en BDD avec ces infos
        $user = new User();
        $user->setUsername($data->getUsername());
        $user->setRoles(["ROLE_USER"]);
        $user->setPassword($userPasswordHasher->hashPassword($user,$data->getPassword()));
        $manager->persist($user);

        $manager->flush();

        return new JsonResponse(["result" => true, "token" => $JWTManager->create($user)]);

    }
}
