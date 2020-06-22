<?php

namespace App\Entity;

use App\Repository\ClimbingGroupRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ClimbingGroupRepository::class)
 */
class ClimbingGroup
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
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $dificultyMin;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $dificultyMax;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $releaseAt;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isOpen;

    /**
     * @ORM\Column(type="integer")
     */
    private $maxClimber;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isRegistrationOpened;

    /**
     * @ORM\ManyToOne(targetEntity=Area::class, inversedBy="climbingGroups")
     * @ORM\JoinColumn(nullable=false)
     */
    private $area;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="climbingGroups")
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDificultyMin(): ?string
    {
        return $this->dificultyMin;
    }

    public function setDificultyMin(string $dificultyMin): self
    {
        $this->dificultyMin = $dificultyMin;

        return $this;
    }

    public function getDificultyMax(): ?string
    {
        return $this->dificultyMax;
    }

    public function setDificultyMax(string $dificultyMax): self
    {
        $this->dificultyMax = $dificultyMax;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getReleaseAt(): ?\DateTimeInterface
    {
        return $this->releaseAt;
    }

    public function setReleaseAt(\DateTimeInterface $releaseAt): self
    {
        $this->releaseAt = $releaseAt;

        return $this;
    }

    public function getIsOpen(): ?bool
    {
        return $this->isOpen;
    }

    public function setIsOpen(bool $isOpen): self
    {
        $this->isOpen = $isOpen;

        return $this;
    }

    public function getMaxClimber(): ?int
    {
        return $this->maxClimber;
    }

    public function setMaxClimber(int $maxClimber): self
    {
        $this->maxClimber = $maxClimber;

        return $this;
    }

    public function getIsRegistrationOpened(): ?bool
    {
        return $this->isRegistrationOpened;
    }

    public function setIsRegistrationOpened(bool $isRegistrationOpened): self
    {
        $this->isRegistrationOpened = $isRegistrationOpened;

        return $this;
    }

    public function getArea(): ?Area
    {
        return $this->area;
    }

    public function setArea(?Area $area): self
    {
        $this->area = $area;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
