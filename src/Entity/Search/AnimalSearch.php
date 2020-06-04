<?php
declare(strict_types=1);

namespace App\Entity\Search;

use App\Entity\Espece;
use App\Entity\Personne;

class AnimalSearch
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
     * @var Espece[]|null
     */
    private $especes = [];
    /**
     * @var Personne[]|null
     */
    private $maitres = [];

    /**
     * @return string|null
     */
    public function getNom(): ?string
    {
        return $this->nom;
    }

    /**
     * @param string|null $nom
     * @return AnimalSearch
     */
    public function setNom(?string $nom): AnimalSearch
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
     * @return AnimalSearch
     */
    public function setMinAge(?int $minAge): AnimalSearch
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
     * @return AnimalSearch
     */
    public function setMaxAge(?int $maxAge): AnimalSearch
    {
        $this->maxAge = $maxAge;
        return $this;
    }

    /**
     * @return Espece[]|null
     */
    public function getEspeces(): ?array
    {
        return $this->especes;
    }

    /**
     * @param Espece[]|null $especes
     * @return AnimalSearch
     */
    public function setEspeces(?array $especes): AnimalSearch
    {
        $this->especes = $especes;
        return $this;
    }

    /**
     * @return Personne[]|null
     */
    public function getMaitres(): ?array
    {
        return $this->maitres;
    }

    /**
     * @param Personne[]|null $maitres
     * @return AnimalSearch
     */
    public function setMaitres(?array $maitres): AnimalSearch
    {
        $this->maitres = $maitres;
        return $this;
    }
}