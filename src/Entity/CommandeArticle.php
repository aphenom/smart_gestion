<?php

namespace App\Entity;

use App\Repository\CommandeArticleRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="smartgestion_commande_article")
 * @ORM\Entity(repositoryClass=CommandeArticleRepository::class)
 */
class CommandeArticle {

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
     * @ORM\Column(type="integer")
     */
    private $pu_vente;

    /**
     * @ORM\Column(type="integer")
     */
    private $pu_achat;

    /**
     * @ORM\Column(type="integer")
     */
    private $remise;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date_add;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date_del;

    /**
     * @ORM\Column(type="boolean")
     */
    private $etat_val;

    /**
     * @ORM\Column(type="boolean")
     */
    private $etat_del;

    /**
     * @ORM\ManyToOne(targetEntity=Article::class, inversedBy="commandeArticles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $article;

    /**
     * @ORM\ManyToOne(targetEntity=Commande::class, inversedBy="commandeArticles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $commande;

    /**
     * @ORM\ManyToOne(targetEntity=Entreprise::class, inversedBy="commandeArticles")
     */
    private $entreprise;

    /**
     * Constructor
     */
    public function __construct() {
        $this->etat_val = true;
        $this->etat_del = false;
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

    public function getPuVente(): ?int {
        return $this->pu_vente;
    }

    public function setPuVente(int $pu_vente): self {
        $this->pu_vente = $pu_vente;

        return $this;
    }

    public function getPuAchat(): ?int {
        return $this->pu_achat;
    }

    public function setPuAchat(int $pu_achat): self {
        $this->pu_achat = $pu_achat;

        return $this;
    }

    public function getArticle(): ?Article {
        return $this->article;
    }

    public function setArticle(?Article $article): self {
        $this->article = $article;

        return $this;
    }

    public function getCommande(): ?Commande {
        return $this->commande;
    }

    public function setCommande(?Commande $commande): self {
        $this->commande = $commande;

        return $this;
    }

    public function getDateAdd(): ?\DateTimeInterface {
        return $this->date_add;
    }

    public function setDateAdd(?\DateTimeInterface $date_add): self {
        $this->date_add = $date_add;

        return $this;
    }

    public function getDateDel(): ?\DateTimeInterface {
        return $this->date_del;
    }

    public function setDateDel(?\DateTimeInterface $date_del): self {
        $this->date_del = $date_del;

        return $this;
    }

    public function getEtatVal(): ?bool {
        return $this->etat_val;
    }

    public function setEtatVal(bool $etat_val): self {
        $this->etat_val = $etat_val;

        return $this;
    }

    public function getEtatDel(): ?bool {
        return $this->etat_del;
    }

    public function setEtatDel(bool $etat_del): self {
        $this->etat_del = $etat_del;

        return $this;
    }

    public function getPuVenteFinal(): int {
        return $total = $this->pu_vente - $this->getRemise();
    }

    public function getTotal(): int {
        return $total = $this->getPuVenteFinal() * $this->quantite;
    }

    public function getValeurAchat(): int {
        return $total = $this->pu_achat * $this->quantite;
    }

    public function getRemise(): ?int {
        return $this->remise;
    }

    public function setRemise(int $remise): self {
        $this->remise = $remise;

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
