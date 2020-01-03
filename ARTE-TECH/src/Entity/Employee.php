<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EmployeeRepository")
 */
abstract class Employee implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    // private $hourly_rate;

    // /**
    //  * @ORM\Column(type="string", length=255)
    //  */
    // private $email;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isSubtractor;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    // public function getHourlyRate(): ?int
    // {
    //     return $this->hourly_rate;
    // }

    // public function setHourlyRate(?int $hourly_rate): self
    // {
    //     $this->hourly_rate = $hourly_rate;

    //     return $this;
    // }

    // public function getEmail(): ?string
    // {
    //     return $this->email;
    // }

    // public function setEmail(string $email): self
    // {
    //     $this->email = $email;

    //     return $this;
    // }

    public function getIsSubtractor(): ?bool
    {
        return $this->isSubtractor;
    }

    public function setIsSubtractor(bool $isSubtractor): self
    {
        $this->isSubtractor = $isSubtractor;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }
}
