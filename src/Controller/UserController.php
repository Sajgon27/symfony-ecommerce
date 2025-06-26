<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\UserService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Response;


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

    #[Route('/auth/login', name: 'login_user', methods: ['POST'])]
    public function login(#[CurrentUser()] ?User $user): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/ApiLoginController.php',
        ]);
    }

       #[Route('/auth/logout', name: 'logout_user', methods: ['POST','OPTIONS'])]
    public function logout(Security $security): Response
    {
      // To "logout", remove the cookie
        $response = new Response(null, 200);
        $response->headers->clearCookie('token');

        return $response;
    }
}
