<?php

namespace App\Entity;

use App\Repository\TeamMemberRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TeamMemberRepository::class)]
class TeamMember
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 50)]
    private $firstName;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private $lastName;

    #[ORM\Column(type: 'date', nullable: true)]
    private $birthday;

    #[ORM\Column(type: 'string', length: 255)]
    private $photo;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $callName;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private $weaponOfChoice;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(?\DateTimeInterface $birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getCallName(): ?string
    {
        return $this->callName;
    }

    public function setCallName(?string $callName): self
    {
        $this->callName = $callName;

        return $this;
    }

    public function getWeaponOfChoice(): ?string
    {
        return $this->weaponOfChoice;
    }

    public function setWeaponOfChoice(?string $weaponOfChoice): self
    {
        $this->weaponOfChoice = $weaponOfChoice;

        return $this;
    }
}
