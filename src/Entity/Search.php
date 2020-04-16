<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;


class Search
{


    private $titre;

    /**
     * @return mixed
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * @param mixed $titre
     */
    public function setTitre($titre): void
    {
        $this->titre = $titre;
    }


    public function __construct()
    {


    }
}