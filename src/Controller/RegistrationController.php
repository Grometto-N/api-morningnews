<?php

namespace App\Controller;

use App\Entity\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Response;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_registration',methods: ['POST'])]
    public function index(Request $request, SerializerInterface $serializer, EntityManagerInterface  $manager, UserPasswordHasherInterface $userPasswordHasher, JWTTokenManagerInterface $JWTManager): JsonResponse
    {
        // récuperation des données envoyés
        $data = $serializer->deserialize($request->getContent(),User::class, 'json');
        // création d'un nouvel utilisateur en BDD avec ces infos
        $user = new User();
        $user->setUsername($data->getUsername());
        $user->setRoles(["ROLE_USER"]);
        $user->setPassword($userPasswordHasher->hashPassword($user,$data->getPassword()));
        $manager->persist($user);

        $manager->flush();

        // envoi des données

        return new JsonResponse(['result' => true, 'token' => $JWTManager->create($user)]);
    }
}
