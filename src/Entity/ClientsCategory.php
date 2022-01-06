<?php

namespace App\Entity;

use App\Repository\ClientsCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ClientsCategoryRepository::class)
 */
class ClientsCategory
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
     * @ORM\OneToMany(targetEntity=Communes::class, mappedBy="category", orphanRemoval=true)
     */
    private $communes;

    public function __toString()
    {
        return $this->getName();
    }

    public function __construct()
    {
        $this->communes = new ArrayCollection();
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
     * @return Collection|Communes[]
     */
    public function getCommunes(): Collection
    {
        return $this->communes;
    }

    public function addCommune(Communes $commune): self
    {
        if (!$this->communes->contains($commune)) {
            $this->communes[] = $commune;
            $commune->setCategory($this);
        }

        return $this;
    }

    public function removeCommune(Communes $commune): self
    {
        if ($this->communes->removeElement($commune)) {
            // set the owning side to null (unless already changed)
            if ($commune->getCategory() === $this) {
                $commune->setCategory(null);
            }
        }

        return $this;
    }
}
