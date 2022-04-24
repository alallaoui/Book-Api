<?php

namespace App\DataFixtures;

use App\Entity\Author;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AuthorFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 10; $i++) {
            $author = new Author();
            $author->setFirstName('author ' . $i);
            $author->setLastName('lastName ' . $i);
            $author->setAge(40 + $i);
            $manager->persist($author);
        }
        $manager->flush();
    }
}
