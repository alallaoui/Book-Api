<?php

namespace App\DataFixtures;

use App\Document\Author;
use App\Document\Book;
use Doctrine\Bundle\MongoDBBundle\Fixture\Fixture as MongoFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ODM\MongoDB\DocumentManager;

class BookFixtures extends MongoFixture implements DependentFixtureInterface
{
    public function __construct(private readonly DocumentManager $dm)
    {
    }
    public function load(ObjectManager $manager)
    {
        $authors = $this->dm->getRepository(Author::class)->findAll();
        for ($i = 0; $i < 10; $i++) {
            $book = new Book();
            $book->setTitle('title ' . $i);
            $book->setDescription('long description ' . $i);
            $book->setPrice($i+1);
            $book->setAuthor($authors[$i]);
            $manager->persist($book);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            AuthorFixtures::class,
        ];
    }
}
