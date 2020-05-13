<?php

namespace App\Entity;

use App\Repository\EspeceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EspeceRepository::class)
 */
class Espece
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=60, unique=true)
     */
    private $nom;

    /**
     * @ORM\OneToMany(targetEntity=Animal::class, mappedBy="espece")
     * @ORM\JoinTable(name="animal")
     */
    private $animaux;

    public function __construct()
    {
        $this->animaux = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection|Animal[]
     */
    public function getAnimaux(): Collection
    {
        return $this->animaux;
    }

    public function addAnimaux(Animal $animaux): self
    {
        if (!$this->animaux->contains($animaux)) {
            $this->animaux[] = $animaux;
            $animaux->setEspece($this);
        }

        return $this;
    }

    public function removeAnimaux(Animal $animaux): self
    {
        if ($this->animaux->contains($animaux)) {
            $this->animaux->removeElement($animaux);
            // set the owning side to null (unless already changed)
            if ($animaux->getEspece() === $this) {
                $animaux->setEspece(null);
            }
        }

        return $this;
    }
}
