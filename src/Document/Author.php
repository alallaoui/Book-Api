<?php

namespace App\Document;

use App\Repository\AuthorRepository;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Doctrine\ODM\MongoDB\Types\Type;

/**
 * @MongoDB\Document(repositoryClass="\App\Repository\BookRepository")
 */
class Author
{
    /**
     * @MongoDB\Id(strategy="INCREMENT")
     */
    private $id;

    /**
     * @MongoDB\Field(type="string")
     */
    private string $firstName;

    /**
     * @MongoDB\Field(type="string")
     */
    private string $lastName;

    /**
     * @MongoDB\Field(type="int")
     */
    private ?int $age = null;

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
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     * @return $this
     */
    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * @return string|null
     */
    #[Groups('book')]
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     * @return $this
     */
    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @return int|null
     */
    #[Groups('book')]
    public function getAge(): ?int
    {
        return $this->age;
    }

    /**
     * @param int|null $age
     * @return $this
     */
    public function setAge(?int $age): self
    {
        $this->age = $age;

        return $this;
    }
}
