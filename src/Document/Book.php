<?php

namespace App\Document;

use App\Repository\BookRepository;
use Doctrine\ODM\MongoDB\Mapping\Annotations\ReferenceOne;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Doctrine\ODM\MongoDB\Types\Type;

/**
 * @MongoDB\Document(repositoryClass="\App\Repository\BookRepository")
 */
class Book
{
    /**
     * @MongoDB\Id(strategy="INCREMENT")
     */
    private $id;

    /**
     * @MongoDB\Field(type="string")
     */
    private ?string $title = null;

    /**
     * @MongoDB\Field(type="string")
     */
    private ?string $description = null;

    /**
     * @MongoDB\Field(type="int")
     */
    private ?int $price = null;

    /**
     * @ReferenceOne(targetDocument=Author::class)
     */
    public Author $author;

    /**
     * @return string|null
     */
    #[Groups('id')]
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    #[Groups('book')]
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string|null
     */
    #[Groups('book')]
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     * @return $this
     */
    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return int|null
     */
    #[Groups('book')]
    public function getPrice(): ?int
    {
        return $this->price;
    }

    /**
     * @param int $price
     * @return $this
     */
    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return Author
     */
    #[Groups('book')]
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param Author $author
     * @return $this
     */
    public function setAuthor(Author $author): self
    {
        $this->author = $author;

        return $this;

    }
}
