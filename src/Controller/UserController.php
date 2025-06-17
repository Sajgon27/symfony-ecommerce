<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\UserService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

final class UserController extends AbstractController
{
    #[Route('/auth/register', name: 'regsiter_user', methods: ['POST'])]
    public function register(
        Request $request,
        UserService $service,
        EntityManagerInterface $em,
    ): JsonResponse {
        $user = $service->handleRegistration($request->getContent());
        $em->persist($user);
        $em->flush();

        return $this->json([
            "user" => $user
        ]);
    }
}
