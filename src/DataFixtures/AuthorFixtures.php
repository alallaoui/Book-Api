<?php

namespace App\DataFixtures;

use App\Document\Author;
use Doctrine\Bundle\MongoDBBundle\Fixture\Fixture as MongoFixture;
use Doctrine\Persistence\ObjectManager;

class AuthorFixtures extends MongoFixture
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
