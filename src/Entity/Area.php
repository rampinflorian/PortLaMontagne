<?php

namespace App\Entity;

use App\Repository\AreaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AreaRepository::class)
 */
class Area
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $orientation;

    /**
     * @ORM\Column(type="string", length=3)
     */
    private $dificultyMax;

    /**
     * @ORM\Column(type="string", length=3)
     */
    private $dificultyMin;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=Site::class, inversedBy="areas")
     * @ORM\JoinColumn(nullable=false)
     */
    private $site;

    /**
     * @ORM\OneToMany(targetEntity=ClimbingGroup::class, mappedBy="area")
     */
    private $climbingGroups;

    public function __construct()
    {
        $this->climbingGroups = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrientation(): ?string
    {
        return $this->orientation;
    }

    public function setOrientation(string $orientation): self
    {
        $this->orientation = $orientation;

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

    public function getDificultyMin(): ?string
    {
        return $this->dificultyMin;
    }

    public function setDificultyMin(string $dificultyMin): self
    {
        $this->dificultyMin = $dificultyMin;

        return $this;
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

    public function getSite(): ?Site
    {
        return $this->site;
    }

    public function setSite(?Site $site): self
    {
        $this->site = $site;

        return $this;
    }

    /**
     * @return Collection|ClimbingGroup[]
     */
    public function getClimbingGroups(): Collection
    {
        return $this->climbingGroups;
    }

    public function addClimbingGroup(ClimbingGroup $climbingGroup): self
    {
        if (!$this->climbingGroups->contains($climbingGroup)) {
            $this->climbingGroups[] = $climbingGroup;
            $climbingGroup->setArea($this);
        }

        return $this;
    }

    public function removeClimbingGroup(ClimbingGroup $climbingGroup): self
    {
        if ($this->climbingGroups->contains($climbingGroup)) {
            $this->climbingGroups->removeElement($climbingGroup);
            // set the owning side to null (unless already changed)
            if ($climbingGroup->getArea() === $this) {
                $climbingGroup->setArea(null);
            }
        }

        return $this;
    }
}
