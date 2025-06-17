<?php 
namespace App\Service;

use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Serializer\SerializerInterface;

class UserService {
    public function __construct(
        private SerializerInterface $serializer,
        private UserPasswordHasherInterface $passwordHasher
    )
    {}

    public function handleRegistration(string $body): User
     {
        $user = $this->serializer->deserialize($body, User::class, 'json');

        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            $user->getPassword()
        );
        $user->setPassword($hashedPassword);
        return $user;
    }
}