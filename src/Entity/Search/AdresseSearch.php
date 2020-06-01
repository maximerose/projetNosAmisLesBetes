<?php
declare(strict_types=1);

namespace App\Entity\Search;


class AdresseSearch
{
    /**
     * @var string|null
     */
    private $intitule;

    /**
     * @return string|null
     */
    public function getIntitule(): ?string
    {
        return $this->intitule;
    }

    /**
     * @param string $intitule
     * @return AdresseSearch
     */
    public function setIntitule(?string $intitule): AdresseSearch
    {
        $this->intitule = $intitule;
        return $this;
    }


}