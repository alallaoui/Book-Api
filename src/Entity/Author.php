<?php

namespace App\Entity;

use App\Repository\AuthorRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: AuthorRepository::class)]
class Author
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 40)]
    private string $firstName;

    #[ORM\Column(type: 'string', length: 40)]
    private string $lastName;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $age = null;

    /**
     * @return int|null
     */
    #[Groups('id')]
    public function getId(): ?int
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
