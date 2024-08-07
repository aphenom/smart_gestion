<?php

namespace App\Entity;

use App\Repository\DebitArticleRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="smartgestion_debit_article")
 * @ORM\Entity(repositoryClass=DebitArticleRepository::class)
 */
class DebitArticle {

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantite;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $objet;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ref_article;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date_add;

    /**
     * @ORM\Column(type="boolean")
     */
    private $etat_defectueux;

    /**
     * @ORM\ManyToOne(targetEntity=Article::class, inversedBy="debitArticles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $article;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="debitArticles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user_add;

    /**
     * @ORM\ManyToOne(targetEntity=Entreprise::class, inversedBy="debitArticles")
     */
    private $entreprise;

    /**
     * Constructor
     */
    public function __construct() {
        $this->etat_defectueux = false;
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getQuantite(): ?int {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self {
        $this->quantite = $quantite;

        return $this;
    }

    public function getObjet(): ?string {
        return $this->objet;
    }

    public function setObjet(?string $objet): self {
        $this->objet = $objet;

        return $this;
    }

    public function getRefArticle(): ?string {
        return $this->ref_article;
    }

    public function setRefArticle(?string $ref_article): self {
        $this->ref_article = $ref_article;

        return $this;
    }

    public function getArticle(): ?Article {
        return $this->article;
    }

    public function setArticle(?Article $article): self {
        $this->article = $article;

        return $this;
    }

    public function getUserAdd(): ?User {
        return $this->user_add;
    }

    public function setUserAdd(?User $user_add): self {
        $this->user_add = $user_add;

        return $this;
    }

    public function getDateAdd(): ?\DateTimeInterface
    {
        return $this->date_add;
    }

    public function setDateAdd(?\DateTimeInterface $date_add): self
    {
        $this->date_add = $date_add;

        return $this;
    }

    public function getEtatDefectueux(): ?bool
    {
        return $this->etat_defectueux;
    }

    public function setEtatDefectueux(bool $etat_defectueux): self
    {
        $this->etat_defectueux = $etat_defectueux;

        return $this;
    }

    public function getEntreprise(): ?Entreprise
    {
        return $this->entreprise;
    }

    public function setEntreprise(?Entreprise $entreprise): self
    {
        $this->entreprise = $entreprise;

        return $this;
    }

}
