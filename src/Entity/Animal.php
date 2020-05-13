<?php

namespace App\Entity;

use App\Repository\AnimalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=AnimalRepository::class)
 */
class Animal
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=60)
     */
    private $nom;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     * @Assert\GreaterThan(0)
     */
    private $age;

    /**
     * @ORM\ManyToOne(targetEntity=Espece::class, inversedBy="animaux")
     * @ORM\JoinColumn(nullable=false)
     * @ORM\JoinTable(name="espece")
     */
    private $espece;

    /**
     * @ORM\ManyToMany(targetEntity=Personne::class, mappedBy="animaux")
     * @ORM\JoinTable(name="personne_animal")
     */
    private $maitres;

    public function __construct()
    {
        $this->maitres = new ArrayCollection();
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

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(?int $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function getEspece(): ?Espece
    {
        return $this->espece;
    }

    public function setEspece(?Espece $espece): self
    {
        $this->espece = $espece;

        return $this;
    }

    /**
     * @return Collection|Personne[]
     */
    public function getMaitres(): Collection
    {
        return $this->maitres;
    }

    public function addMaitre(Personne $maitre): self
    {
        if (!$this->maitres->contains($maitre)) {
            $this->maitres[] = $maitre;
            $maitre->addAnimaux($this);
        }

        return $this;
    }

    public function removeMaitre(Personne $maitre): self
    {
        if ($this->maitres->contains($maitre)) {
            $this->maitres->removeElement($maitre);
            $maitre->removeAnimaux($this);
        }

        return $this;
    }
}
