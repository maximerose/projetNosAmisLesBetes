<?php
declare(strict_types=1);

namespace App\Entity\Search;

use App\Entity\Adresse;
use App\Entity\Animal;

class PersonneSearch
{
    /**
     * @var string|null
     */
    private $nom;

    /**
     * @var int|null
     */
    private $minAge;

    /**
     * @var int|null
     */
    private $maxAge;

    /**
     * @var string[]|null
     */
    private $sexes;

    /**
     * @var Adresse[]|null
     */
    private $adresses = [];

    /**
     * @var Animal[]|null
     */
    private $animaux = [];

    /**
     * @return string|null
     */
    public function getNom(): ?string
    {
        return $this->nom;
    }

    /**
     * @param string|null $nom
     * @return PersonneSearch
     */
    public function setNom(?string $nom): PersonneSearch
    {
        $this->nom = $nom;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getMinAge(): ?int
    {
        return $this->minAge;
    }

    /**
     * @param int|null $minAge
     * @return PersonneSearch
     */
    public function setMinAge(?int $minAge): PersonneSearch
    {
        $this->minAge = $minAge;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getMaxAge(): ?int
    {
        return $this->maxAge;
    }

    /**
     * @param int|null $maxAge
     * @return PersonneSearch
     */
    public function setMaxAge(?int $maxAge): PersonneSearch
    {
        $this->maxAge = $maxAge;
        return $this;
    }

    /**
     * @return string[]|null
     */
    public function getSexes(): ?array
    {
        return $this->sexes;
    }

    /**
     * @param string[]|null $sexes
     * @return PersonneSearch
     */
    public function setSexes(?array $sexes): PersonneSearch
    {
        $this->sexes = $sexes;
        return $this;
    }

    /**
     * @return Adresse[]|null
     */
    public function getAdresses(): ?array
    {
        return $this->adresses;
    }

    /**
     * @param array|null $adresses
     * @return PersonneSearch
     */
    public function setAdresses(?array $adresses): PersonneSearch
    {
        $this->adresses = $adresses;
        return $this;
    }

    /**
     * @return Animal[]|null
     */
    public function getAnimaux(): ?array
    {
        return $this->animaux;
    }

    /**
     * @param Animal[]|null $animaux
     * @return PersonneSearch
     */
    public function setAnimaux(?array $animaux): PersonneSearch
    {
        $this->animaux = $animaux;
        return $this;
    }
}