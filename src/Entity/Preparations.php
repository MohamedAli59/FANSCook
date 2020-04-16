<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PreparationsRepository")
 */
class Preparations
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $etapes;

    /**
     * @ORM\Column(type="smallint")
     */
    private $ordres;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_add;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_update;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date_delete;

    /**
     * @ORM\Column(type="boolean")
     */
    private $activate;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Recettes", inversedBy="preparations", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $recettes;

    public function __construct()
    {
        $this->date_add = new \DateTime();
        $this->date_update = new \DateTime();
        $this->activate = 0;

    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEtapes(): ?string
    {
        return $this->etapes;
    }

    public function setEtapes(string $etapes): self
    {
        $this->etapes = $etapes;

        return $this;
    }

    public function getOrdres(): ?int
    {
        return $this->ordres;
    }

    public function setOrdres(int $ordres): self
    {
        $this->ordres = $ordres;

        return $this;
    }

    public function getDateAdd(): ?\DateTimeInterface
    {
        return $this->date_add;
    }

    public function setDateAdd(\DateTimeInterface $date_add): self
    {
        $this->date_add = $date_add;

        return $this;
    }

    public function getDateUpdate(): ?\DateTimeInterface
    {
        return $this->date_update;
    }

    public function setDateUpdate(\DateTimeInterface $date_update): self
    {
        $this->date_update = $date_update;

        return $this;
    }

    public function getDateDelete(): ?\DateTimeInterface
    {
        return $this->date_delete;
    }

    public function setDateDelete(?\DateTimeInterface $date_delete): self
    {
        $this->date_delete = $date_delete;

        return $this;
    }

    public function getActivate(): ?bool
    {
        return $this->activate;
    }

    public function setActivate(bool $activate): self
    {
        $this->activate = $activate;

        return $this;
    }

    public function getRecettes(): ?recettes
    {
        return $this->recettes;
    }

    public function setRecettes(recettes $recettes): self
    {
        $this->recettes = $recettes;

        return $this;
    }
}
