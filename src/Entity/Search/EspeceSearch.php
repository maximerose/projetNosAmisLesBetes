<?php
declare(strict_types=1);

namespace App\Entity\Search;


class EspeceSearch
{
    /**
     * @var string|null
     */
    private $nom;

    /**
     * @return string|null
     */
    public function getNom(): ?string
    {
        return $this->nom;
    }

    /**
     * @param string|null $nom
     * @return EspeceSearch
     */
    public function setNom(?string $nom): EspeceSearch
    {
        $this->nom = $nom;
        return $this;
    }
}