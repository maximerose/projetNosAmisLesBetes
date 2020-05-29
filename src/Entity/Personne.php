<?php
declare(strict_types=1);

namespace App\Entity;

use App\Repository\PersonneRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=PersonneRepository::class)
 */
class Personne
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
     * @ORM\Column(type="string", length=1)
     * @Assert\Regex("/M|F/")
     */
    private $sexe;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     * @Assert\GreaterThan(0)
     * @Assert\LessThan(130)
     */
    private $age;

    /**
     * @ORM\ManyToOne(targetEntity=Adresse::class, inversedBy="personnes")
     * @ORM\JoinTable(name="adresse")
     */
    private $adresse;

    /**
     * @ORM\ManyToMany(targetEntity=Animal::class, mappedBy="maitres")
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

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(string $sexe): self
    {
        $this->sexe = $sexe;

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

    public function getAdresse(): ?Adresse
    {
        return $this->adresse;
    }

    public function setAdresse(?Adresse $adresse): self
    {
        $this->adresse = $adresse;
        return $this;
    }

    /**
     * @return Collection|Animal[]
     */
    public function getAnimaux(): Collection
    {
        return $this->animaux;
    }

    public function addAnimaux(Animal $animal): self
    {
        if (!$this->animaux->contains($animal)) {
            $this->animaux[] = $animal;
            $animal->addMaitre($this);
        }

        return $this;
    }

    public function removeAnimaux(Animal $animal): self
    {
        if ($this->animaux->contains($animal)) {
            $this->animaux->removeElement($animal);
            $animal->removeMaitre($this);
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->getNom();
    }
}
