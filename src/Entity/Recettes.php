<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RecettesRepository")
 */
class Recettes
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
    private $titre;


    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @ORM\Column(type="boolean")
     */
    private $top_recette;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $note_moyenne;

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
     * @ORM\ManyToOne(targetEntity="App\Entity\Categories", inversedBy="recettes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $categories;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Preparations", mappedBy="recettes", cascade={"persist", "remove"})
     */
    private $preparations;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Users", inversedBy="recettes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $users;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Ingredients", mappedBy="recettes")
     */
    private $ingredients;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Commentaires", mappedBy="recettes", orphanRemoval=true)
     */
    private $commentaires;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Favoris", mappedBy="recettes")
     */
    private $favoris;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Notes", mappedBy="recettes")
     */
    private $notes;

    /**
     * @ORM\Column(type="text")
     */
    private $descriptions;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $tmp_prepa;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $tmp_cuisson;

    public function __construct()
    {
        $this->ingredients = new ArrayCollection();
        $this->preparations = new ArrayCollection();
        $this->commentaires = new ArrayCollection();
        $this->favoris = new ArrayCollection();
        $this->notes = new ArrayCollection();
        $this->date_add = new \DateTime();
        $this->date_update = new \DateTime();
        $this->activate = 0;
        $this->top_recette = 0;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getTopRecette(): ?bool
    {
        return $this->top_recette;
    }

    public function setTopRecette(bool $top_recette): self
    {
        $this->top_recette = $top_recette;

        return $this;
    }

    public function getNoteMoyenne(): ?float
    {
        return $this->note_moyenne;
    }

    public function setNoteMoyenne(float $note_moyenne): self
    {
        $this->note_moyenne = $note_moyenne;

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

    public function setDateDelete(\DateTimeInterface $date_delete): self
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

    public function getCategories(): ?categories
    {
        return $this->categories;
    }

    public function setCategories(?categories $categories): self
    {
        $this->categories = $categories;

        return $this;
    }

    /**
     * @return Collection|Preparations[]
     */
    public function getPreparations(): Collection
    {
        return $this->preparations;
    }

    public function setPreparations(Preparations $preparations): self
    {
        $this->preparations = $preparations;

        // set the owning side of the relation if necessary
        if ($preparations->getRecettes() !== $this) {
            $preparations->setRecettes($this);
        }

        return $this;
    }

    public function getUsers(): ?users
    {
        return $this->users;
    }

    public function setUsers(?users $users): self
    {
        $this->users = $users;

        return $this;
    }

    /**
     * @return Collection|Ingredients[]
     */
    public function getIngredients(): Collection
    {
        return $this->ingredients;
    }

    public function addIngredient(Ingredients $ingredient): self
    {
        if (!$this->ingredients->contains($ingredient)) {
            $this->ingredients[] = $ingredient;
            $ingredient->setRecettes($this);
        }

        return $this;
    }

    public function removeIngredient(Ingredients $ingredient): self
    {
        if ($this->ingredients->contains($ingredient)) {
            $this->ingredients->removeElement($ingredient);
            // set the owning side to null (unless already changed)
            if ($ingredient->getRecettes() === $this) {
                $ingredient->setRecettes(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Commentaires[]
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaires $commentaire): self
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires[] = $commentaire;
            $commentaire->setRecettes($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaires $commentaire): self
    {
        if ($this->commentaires->contains($commentaire)) {
            $this->commentaires->removeElement($commentaire);
            // set the owning side to null (unless already changed)
            if ($commentaire->getRecettes() === $this) {
                $commentaire->setRecettes(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Favoris[]
     */
    public function getFavoris(): Collection
    {
        return $this->favoris;
    }

    public function addFavori(Favoris $favori): self
    {
        if (!$this->favoris->contains($favori)) {
            $this->favoris[] = $favori;
            $favori->setRecettes($this);
        }

        return $this;
    }

    public function removeFavori(Favoris $favori): self
    {
        if ($this->favoris->contains($favori)) {
            $this->favoris->removeElement($favori);
            // set the owning side to null (unless already changed)
            if ($favori->getRecettes() === $this) {
                $favori->setRecettes(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Notes[]
     */
    public function getNotes(): Collection
    {
        return $this->notes;
    }

    public function addNote(Notes $note): self
    {
        if (!$this->notes->contains($note)) {
            $this->notes[] = $note;
            $note->setRecettes($this);
        }

        return $this;
    }

    public function removeNote(Notes $note): self
    {
        if ($this->notes->contains($note)) {
            $this->notes->removeElement($note);
            // set the owning side to null (unless already changed)
            if ($note->getRecettes() === $this) {
                $note->setRecettes(null);
            }
        }

        return $this;
    }

    public function getDescriptions(): ?string
    {
        return $this->descriptions;
    }

    public function setDescriptions(string $descriptions): self
    {
        $this->descriptions = $descriptions;

        return $this;
    }

    public function getTmpPrepa(): ?string
    {
        return $this->tmp_prepa;
    }

    public function setTmpPrepa(string $tmp_prepa): self
    {
        $this->tmp_prepa = $tmp_prepa;

        return $this;
    }

    public function getTmpCuisson(): ?string
    {
        return $this->tmp_cuisson;
    }

    public function setTmpCuisson(?string $tmp_cuisson): self
    {
        $this->tmp_cuisson = $tmp_cuisson;

        return $this;
    }
}
