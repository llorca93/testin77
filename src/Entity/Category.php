<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Assainissement::class, mappedBy="category", orphanRemoval=true)
     */
    private $assainissements;

    public function __toString()
    {
        return $this->getName();
    }

    public function __construct()
    {
        $this->assainissements = new ArrayCollection();
    }

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

    /**
     * @return Collection|Assainissement[]
     */
    public function getAssainissements(): Collection
    {
        return $this->assainissements;
    }

    public function addAssainissement(Assainissement $assainissement): self
    {
        if (!$this->assainissements->contains($assainissement)) {
            $this->assainissements[] = $assainissement;
            $assainissement->setCategory($this);
        }

        return $this;
    }

    public function removeAssainissement(Assainissement $assainissement): self
    {
        if ($this->assainissements->removeElement($assainissement)) {
            // set the owning side to null (unless already changed)
            if ($assainissement->getCategory() === $this) {
                $assainissement->setCategory(null);
            }
        }

        return $this;
    }
}
