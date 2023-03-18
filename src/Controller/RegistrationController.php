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

class RegistrationController extends AbstractController
{
    #[Route('/registration', name: 'app_registration',methods: ['POST'])]
    public function index(Request $request, SerializerInterface $serializer, EntityManagerInterface  $manager, UserPasswordHasherInterface $userPasswordHasher): JsonResponse
    {
        $user = $serializer->deserialize($request->getContent(), 'json');
        dd($user);
        // $user = $serializer->deserialize($request->getContent(), User::class, 'json');
        // dd($user->getPassword());
        // $user = new User();
        // $user->setUsername("Nicolas");
        // $user->setRoles(["ROLE_USER"]);
        // $user->setPassword($userPasswordHasher->hashPassword($user,"abcdef"));
        $manager->persist($user);

        $manager->flush();

        $jsonUser = $serializer->serialize($user, 'json', ['groups' => 'getBooks']);
        
        // $location = $urlGenerator->generate('detailBook', ['id' => $book->getId()], UrlGeneratorInterface::ABSOLUTE_URL);

        // return new JsonResponse($jsonBook, Response::HTTP_CREATED, ["Location" => $location], true);

        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/RegistrationController.php',
        ]);
        // new JsonResponse
    }
}
