<?php

namespace App\DataFixtures;

use App\Entity\Author;
use App\Entity\Book;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;

class BookFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(private readonly EntityManagerInterface $em)
    {
    }
    public function load(ObjectManager $manager)
    {
        $authors = $this->em->getRepository(Author::class)->findAll();
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
