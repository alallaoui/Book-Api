<?php

namespace App\DataFixtures;

use App\Document\User;
use Doctrine\Bundle\MongoDBBundle\Fixture\Fixture as MongoFixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends MongoFixture
{
    public function __construct(private readonly UserPasswordHasherInterface $hasher)
    {
    }

    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setEmail('user' . $i . '@books-library.com');
            $password = $this->hasher->hashPassword($user, 'pass_' . $i);
            $user->setPassword($password);
            $manager->persist($user);
        }
        $manager->flush();
    }
}
