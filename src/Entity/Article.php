<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Entity\File as EmbeddedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Table(name="smartgestion_article")
 * @ORM\Entity(repositoryClass=ArticleRepository::class)
 * @Vich\Uploadable
 */
class Article {

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * 
     * @Vich\UploadableField(mapping="product_image", fileNameProperty="image.name", size="image.size", mimeType="image.mimeType", originalName="image.originalName", dimensions="image.dimensions")
     * 
     * @var File|null
     */
    private $imageFile;

    /**
     * @ORM\Embedded(class="Vich\UploaderBundle\Entity\File")
     *
     * @var EmbeddedFile
     */
    private $image;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="integer")
     */
    private $pu_vente;

    /**
     * @ORM\Column(type="integer")
     */
    private $pu_achat;

    /**
     * @ORM\Column(type="string", length=255, unique=true, nullable=true)
     */
    private $sku;

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
     * @ORM\Column(type="boolean")
     */
    private $etat_proprio;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nom_proprio;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="article_adds")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user_add;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="article_dels")
     * @ORM\JoinColumn(nullable=true)
     */
    private $user_del;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="article_vals")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user_val;

    /**
     * @ORM\OneToMany(targetEntity=CommandeArticle::class, mappedBy="article")
     */
    private $commandeArticles;

    /**
     * @ORM\OneToMany(targetEntity=CreditArticle::class, mappedBy="article")
     */
    private $creditArticles;

    /**
     * @ORM\OneToMany(targetEntity=DebitArticle::class, mappedBy="article")
     */
    private $debitArticles;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $seuil_approvisionnement;

    /**
     * @ORM\ManyToOne(targetEntity=Entreprise::class, inversedBy="articles")
     */
    private $entreprise;

    /**
     * Constructor
     */
    public function __construct() {
        $this->etat_val = true;
        $this->etat_del = false;
        $this->etat_proprio = true;
        $this->commandeArticles = new ArrayCollection();
        $this->creditArticles = new ArrayCollection();
        $this->debitArticles = new ArrayCollection();
        $this->image = new EmbeddedFile();
    }

    public function getId(): ?int {
        return $this->id;
    }

//    public function getImage(): ?string {
//        return $this->image;
//    }
//
//    public function setImage(string $image): self {
//        $this->image = $image;
//
//        return $this;
//    }

    public function getNom(): ?string {
        return $this->nom;
    }

    public function setNom(string $nom): self {
        $this->nom = $nom;

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

    public function getSku(): ?string {
        return $this->sku;
    }

    public function setSku(string $sku): self {
        $this->sku = $sku;

        return $this;
    }

    public function getUserAdd(): ?User {
        return $this->user_add;
    }

    public function setUserAdd(?User $user_add): self {
        $this->user_add = $user_add;

        return $this;
    }

    public function getUserDel(): ?User {
        return $this->user_del;
    }

    public function setUserDel(?User $user_del): self {
        $this->user_del = $user_del;

        return $this;
    }

    public function getUserVal(): ?User {
        return $this->user_val;
    }

    public function setUserVal(?User $user_val): self {
        $this->user_val = $user_val;

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

    public function getEtatProprio(): ?bool {
        return $this->etat_proprio;
    }

    public function setEtatProprio(bool $etat_proprio): self {
        $this->etat_proprio = $etat_proprio;

        return $this;
    }

    public function getNomProprio(): ?string {
        return $this->nom_proprio;
    }

    public function setNomProprio(?string $nom_proprio): self {
        $this->nom_proprio = $nom_proprio;

        return $this;
    }

    /**
     * @return Collection|CommandeArticle[]
     */
    public function getCommandeArticles(): Collection {
        return $this->commandeArticles;
    }

    public function addCommandeArticle(CommandeArticle $commandeArticle): self {
        if (!$this->commandeArticles->contains($commandeArticle)) {
            $this->commandeArticles[] = $commandeArticle;
            $commandeArticle->setArticle($this);
        }

        return $this;
    }

    public function removeCommandeArticle(CommandeArticle $commandeArticle): self {
        if ($this->commandeArticles->contains($commandeArticle)) {
            $this->commandeArticles->removeElement($commandeArticle);
            // set the owning side to null (unless already changed)
            if ($commandeArticle->getArticle() === $this) {
                $commandeArticle->setArticle(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|CreditArticle[]
     */
    public function getCreditArticles(): Collection {
        return $this->creditArticles;
    }

    public function addCreditArticle(CreditArticle $creditArticle): self {
        if (!$this->creditArticles->contains($creditArticle)) {
            $this->creditArticles[] = $creditArticle;
            $creditArticle->setArticle($this);
        }

        return $this;
    }

    public function removeCreditArticle(CreditArticle $creditArticle): self {
        if ($this->creditArticles->contains($creditArticle)) {
            $this->creditArticles->removeElement($creditArticle);
            // set the owning side to null (unless already changed)
            if ($creditArticle->getArticle() === $this) {
                $creditArticle->setArticle(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|DebitArticle[]
     */
    public function getDebitArticles(): Collection {
        return $this->debitArticles;
    }

    public function addDebitArticle(DebitArticle $debitArticle): self {
        if (!$this->debitArticles->contains($debitArticle)) {
            $this->debitArticles[] = $debitArticle;
            $debitArticle->setArticle($this);
        }

        return $this;
    }

    public function removeDebitArticle(DebitArticle $debitArticle): self {
        if ($this->debitArticles->contains($debitArticle)) {
            $this->debitArticles->removeElement($debitArticle);
            // set the owning side to null (unless already changed)
            if ($debitArticle->getArticle() === $this) {
                $debitArticle->setArticle(null);
            }
        }

        return $this;
    }

    public function getSeuilApprovisionnement(): ?int {
        return $this->seuil_approvisionnement;
    }

    public function setSeuilApprovisionnement(?int $seuil_approvisionnement): self {
        $this->seuil_approvisionnement = $seuil_approvisionnement;

        return $this;
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the  update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|UploadedFile|null $imageFile
     */
    public function setImageFile(?File $imageFile = null) {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File {
        return $this->imageFile;
    }

    public function setImage(EmbeddedFile $image): void {
        $this->image = $image;
    }

    public function getImage(): ?EmbeddedFile {
        return $this->image;
    }

    public function getDisplayName(): string {
        return $this->sku . "  ---  " . $this->nom . "  -  " . $this->getPuVente() . " FCFA - [" . $this->getQuantiteStock() . " disponible(s)] ";
    }

    public function getQuantiteCommandeArticles(): int {
        $quantite = 0;
        foreach ($this->commandeArticles as $commandeArticle) {
            if ($commandeArticle->getEtatVal() == true && $commandeArticle->getEtatDel() == false && ($commandeArticle->getCommande()->getEtat()["etat"] != "livraison-val" || $commandeArticle->getCommande()->getEtat()["etat"] != "comptabilite")) {
                $quantite += $commandeArticle->getQuantite();
            }
        }
        return $quantite;
    }

    public function getQuantiteCommandeArticlesEnCours(): int {
        $quantite = 0;
        foreach ($this->commandeArticles as $commandeArticle) {
            if ($commandeArticle->getEtatVal() == true && $commandeArticle->getEtatDel() == false && $commandeArticle->getCommande()->getEtat()["etat"] != "livraison-val" && $commandeArticle->getCommande()->getEtat()["etat"] != "comptabilite") {
                $quantite += $commandeArticle->getQuantite();
            }
        }
        return $quantite;
    }

    public function getQuantiteCredit(): int {
        $quantite = 0;
        foreach ($this->creditArticles as $creditArticle) {
            $quantite += $creditArticle->getQuantite();
        }
        return $quantite;
    }

    public function getQuantiteDebit(): int {
        $quantite = 0;
        foreach ($this->debitArticles as $debitArticle) {
            $quantite += $debitArticle->getQuantite();
        }
        return $quantite;
    }

    public function getQuantiteDefectueux(): int {
        $quantite = 0;
        foreach ($this->debitArticles as $debitArticle) {
            if ($debitArticle->getEtatDefectueux() == true) {
                $quantite += $debitArticle->getQuantite();
            }
        }
        return $quantite;
    }

    public function getQuantiteStock(): int {

        return $quantite = $this->getQuantiteCredit() - ($this->getQuantiteDebit() + $this->getQuantiteCommandeArticles());
    }

    public function getEntreprise(): ?Entreprise {
        return $this->entreprise;
    }

    public function setEntreprise(?Entreprise $entreprise): self {
        $this->entreprise = $entreprise;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self {
        $this->updatedAt = $updatedAt;

        return $this;
    }

}
