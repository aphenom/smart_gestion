<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="smartgestion_commande")
 * @ORM\Entity(repositoryClass=CommandeRepository::class)
 */
class Commande {

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type_commande;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom_client;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $numero_client;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date_livraison_souhaite;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lieu_livraison;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $frais_livraison;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $montant_recu;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date_montant;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $sku;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $commentaire;

    /**
     * @ORM\Column(type="boolean")
     */
    private $etat_proprio;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date_add;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date_val;

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
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date_lancement;

    /**
     * @ORM\Column(type="boolean")
     */
    private $etat_lancement;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date_livraison;

    /**
     * @ORM\Column(type="boolean")
     */
    private $etat_livraison;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date_livraison_agent;

    /**
     * @ORM\Column(type="boolean")
     */
    private $etat_livraison_agent;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date_livraison_val;

    /**
     * @ORM\Column(type="boolean")
     */
    private $etat_livraison_val;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date_comptabilite;

    /**
     * @ORM\Column(type="boolean")
     */
    private $etat_comptabilite;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $objet_retour;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="commande_adds")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user_add;

    /**
     * @ORM\ManyToOne(targetEntity=Agent::class, inversedBy="commandes")
     */
    private $agent_livreur;

    /**
     * Constructor
     */
    public function __construct() {
        $this->etat_val = false;
        $this->etat_del = false;
        $this->etat_relance = false;
        $this->etat_proprio = true;
        $this->etat_lancement = false;
        $this->etat_livraison = false;
        $this->etat_livraison_agent = false;
        $this->etat_livraison_val = false;
        $this->etat_comptabilite = false;
        $this->commandeArticles = new ArrayCollection();
        $this->historiques = new ArrayCollection();
    }

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="commande_montants")
     */
    private $user_montant;

    /**
     * @ORM\OneToMany(targetEntity=CommandeArticle::class, mappedBy="commande")
     */
    private $commandeArticles;

    /**
     * @ORM\OneToMany(targetEntity=Historique::class, mappedBy="commande")
     */
    private $historiques;

    /**
     * @ORM\Column(type="boolean")
     */
    private $etat_relance;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date_relance;

    /**
     * @ORM\ManyToOne(targetEntity=Entreprise::class, inversedBy="commandes")
     */
    private $entreprise;
    private $type_etat;

    public function getId(): ?int {
        return $this->id;
    }

    public function getTypeCommande(): ?string {
        return $this->type_commande;
    }

    public function setTypeCommande(string $type_commande): self {
        $this->type_commande = $type_commande;

        return $this;
    }

    public function getNomClient(): ?string {
        return $this->nom_client;
    }

    public function setNomClient(string $nom_client): self {
        $this->nom_client = $nom_client;

        return $this;
    }

    public function getNumeroClient(): ?string {
        return $this->numero_client;
    }

    public function setNumeroClient(?string $numero_client): self {
        $this->numero_client = $numero_client;

        return $this;
    }

    public function getLieuLivraison(): ?string {
        return $this->lieu_livraison;
    }

    public function setLieuLivraison(?string $lieu_livraison): self {
        $this->lieu_livraison = $lieu_livraison;

        return $this;
    }

    public function getFraisLivraison(): ?int {
        return $this->frais_livraison;
    }

    public function setFraisLivraison(?int $frais_livraison): self {
        $this->frais_livraison = $frais_livraison;

        return $this;
    }

    public function getMontantRecu(): ?int {
        return $this->montant_recu;
    }

    public function setMontantRecu(?int $montant_recu): self {
        $this->montant_recu = $montant_recu;

        return $this;
    }

    public function getDateMontant(): ?\DateTimeInterface {
        return $this->date_montant;
    }

    public function setDateMontant(?\DateTimeInterface $date_montant): self {
        $this->date_montant = $date_montant;

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

    public function getAgentLivreur(): ?Agent {
        return $this->agent_livreur;
    }

    public function setAgentLivreur(?Agent $agent_livreur): self {
        $this->agent_livreur = $agent_livreur;

        return $this;
    }

    public function getUserMontant(): ?User {
        return $this->user_montant;
    }

    public function setUserMontant(?User $user_montant): self {
        $this->user_montant = $user_montant;

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

    public function getDateLivraison(): ?\DateTimeInterface {
        return $this->date_livraison;
    }

    public function setDateLivraison(?\DateTimeInterface $date_livraison): self {
        $this->date_livraison = $date_livraison;

        return $this;
    }

    public function getEtatLivraison(): ?bool {
        return $this->etat_livraison;
    }

    public function setEtatLivraison(bool $etat_livraison): self {
        $this->etat_livraison = $etat_livraison;
        if ($etat_livraison == true) {
            $this->setDateLivraison(new \DateTime());
        }

        return $this;
    }

    public function getObjetRetour(): ?string {
        return $this->objet_retour;
    }

    public function setObjetRetour(?string $objet_retour): self {
        $this->objet_retour = $objet_retour;

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
            $commandeArticle->setCommande($this);
        }

        return $this;
    }

    public function removeCommandeArticle(CommandeArticle $commandeArticle): self {
        if ($this->commandeArticles->contains($commandeArticle)) {
            $this->commandeArticles->removeElement($commandeArticle);
            // set the owning side to null (unless already changed)
            if ($commandeArticle->getCommande() === $this) {
                $commandeArticle->setCommande(null);
            }
        }

        return $this;
    }

    public function getTotalCommandeArticle(): int {
        $total = 0;
        foreach ($this->commandeArticles as $commandeArticle) {
            if ($commandeArticle->getEtatVal() == true && $commandeArticle->getEtatDel() == false) {
                $total += $commandeArticle->getTotal();
            }
        }
        return $total;
    }

    public function getAchatCommandeArticle(): int {
        $total = 0;
        foreach ($this->commandeArticles as $commandeArticle) {
            if ($commandeArticle->getEtatVal() == true && $commandeArticle->getEtatDel() == false) {
                $total += $commandeArticle->getValeurAchat();
            }
        }
        return $total;
    }

    public function getTotal(): int {
        if ($this->frais_livraison == null) {
            $total = $this->getTotalCommandeArticle();
        } else {
            $total = $this->frais_livraison + $this->getTotalCommandeArticle();
        }
        return $total;
    }

    public function getEtat(): array {
        $etat = "non-val";
        $etatLibelle = "Commande non valide";
//        $etatLibelleNext = "Commande en attente de validation";
        $etatLibelleNext = "En attente Validation";
        $etatCouleur = "dark";
        $etatDate = $this->getDateAdd();
        //step validation (commercial)
        if ($this->etat_val == true) {
            $etat = "val";
            $etatLibelle = "Commande validée";
//            $etatLibelleNext = "Commande en attente de lancement du LOG";
            $etatLibelleNext = "En attente lancement LOG";
            $etatCouleur = "secondary";
            $etatDate = $this->getDateVal();
            //step lancement (log)
            if ($this->etat_lancement == true) {
                $etat = "lancement";
                if ($this->etat_proprio == true) {
                    $etatLibelle = "Commande lancée par le LOG";
                    $etatDate = $this->getDateLancement();
                } else {
                    $etatLibelle = "Commande en attente livraison";
                    $etatDate = $this->getDateAdd();
                }
//                $etatLibelleNext = "Commande en attente livraison";
                $etatLibelleNext = "En attente Livraison";
                $etatCouleur = "light";
                //step livraison
                if ($this->etat_livraison == true) {
                    $etat = "livraison";
                    $etatLibelle = "Livraison en cours";
//                    $etatLibelleNext = "En attente de validation du livreur";
                    $etatLibelleNext = "En attente validation Livreur";
                    $etatCouleur = "primary";
                    $etatDate = $this->getDateLivraison();
                    //step livraison agent
                    if ($this->etat_livraison_agent == true) {
                        $etat = "livraison-agent";
                        $etatLibelle = "Commande livrée";
//                        $etatLibelleNext = "Livraison en attente de validation";
                        $etatLibelleNext = "En attente validation Livraison";
                        $etatCouleur = "light";
                        $etatDate = $this->getDateLivraisonAgent();
                        //step livraison valide
                        if ($this->etat_livraison_val == true) {
                            $etat = "livraison-val";
                            $etatLibelle = "Livraison validée";
//                            $etatLibelleNext = "Comptabilité en attente de validation";
                            $etatLibelleNext = "En attente validation Comptabilité";
                            $etatCouleur = "info";
                            $etatDate = $this->getDateLivraisonVal();
                            //step comptabilite
                            if ($this->etat_comptabilite == true) {
                                $etat = "comptabilite";
                                $etatLibelle = "Comptabilité validée";
                                $etatLibelleNext = "Comptabilité validée";
                                $etatCouleur = "success";
                                $etatDate = $this->getDateComptabilite();
                            }
                        }
                    }
                }
            }
        } else {
            if ($this->etat_relance == true) {
                $etat = "relance";
                $etatLibelle = "A relancer";
                $etatLibelleNext = "A relancer";
                $etatCouleur = "warning";
                $etatDate = $this->getDateRelance();
            }
            if ($this->etat_del == true) {
                $etat = "del";
                $etatLibelle = "Annulé";
                $etatLibelleNext = "Annulé";
                $etatCouleur = "danger";
                $etatDate = $this->getDateDel();
            }
        }
        return $etat = array('etat' => $etat, 'etatLibelle' => $etatLibelle, 'etatLibelleNext' => $etatLibelleNext, 'etatCouleur' => $etatCouleur, 'etatDate' => $etatDate);
    }

    public function getDateLivraisonSouhaite(): ?\DateTimeInterface {
        return $this->date_livraison_souhaite;
    }

    public function setDateLivraisonSouhaite(?\DateTimeInterface $date_livraison_souhaite): self {
        $this->date_livraison_souhaite = $date_livraison_souhaite;

        return $this;
    }

    public function getCommentaire(): ?string {
        return $this->commentaire;
    }

    public function setCommentaire(?string $commentaire): self {
        $this->commentaire = $commentaire;

        return $this;
    }

    /**
     * @return Collection|Historique[]
     */
    public function getHistoriques(): Collection {
        return $this->historiques;
    }

    public function addHistorique(Historique $historique): self {
        if (!$this->historiques->contains($historique)) {
            $this->historiques[] = $historique;
            $historique->setCommande($this);
        }

        return $this;
    }

    public function removeHistorique(Historique $historique): self {
        if ($this->historiques->contains($historique)) {
            $this->historiques->removeElement($historique);
            // set the owning side to null (unless already changed)
            if ($historique->getCommande() === $this) {
                $historique->setCommande(null);
            }
        }

        return $this;
    }

    public function getEtatRelance(): ?bool {
        return $this->etat_relance;
    }

    public function setEtatRelance(bool $etat_relance): self {
        $this->etat_relance = $etat_relance;

        return $this;
    }

    public function getDateRelance(): ?\DateTimeInterface {
        return $this->date_relance;
    }

    public function setDateRelance(?\DateTimeInterface $date_relance): self {
        $this->date_relance = $date_relance;

        return $this;
    }

    public function getEntreprise(): ?Entreprise {
        return $this->entreprise;
    }

    public function setEntreprise(?Entreprise $entreprise): self {
        $this->entreprise = $entreprise;

        return $this;
    }

    public function getDateLancement(): ?\DateTimeInterface {
        return $this->date_lancement;
    }

    public function setDateLancement(?\DateTimeInterface $date_lancement): self {
        $this->date_lancement = $date_lancement;

        return $this;
    }

    public function getEtatLancement(): ?bool {
        return $this->etat_lancement;
    }

    public function setEtatLancement(bool $etat_lancement): self {
        $this->etat_lancement = $etat_lancement;

        return $this;
    }

    public function getDateLivraisonAgent(): ?\DateTimeInterface {
        return $this->date_livraison_agent;
    }

    public function setDateLivraisonAgent(?\DateTimeInterface $date_livraison_agent): self {
        $this->date_livraison_agent = $date_livraison_agent;

        return $this;
    }

    public function getEtatLivraisonAgent(): ?bool {
        return $this->etat_livraison_agent;
    }

    public function setEtatLivraisonAgent(bool $etat_livraison_agent): self {
        $this->etat_livraison_agent = $etat_livraison_agent;

        return $this;
    }

    public function getDateLivraisonVal(): ?\DateTimeInterface {
        return $this->date_livraison_val;
    }

    public function setDateLivraisonVal(?\DateTimeInterface $date_livraison_val): self {
        $this->date_livraison_val = $date_livraison_val;

        return $this;
    }

    public function getEtatLivraisonVal(): ?bool {
        return $this->etat_livraison_val;
    }

    public function setEtatLivraisonVal(bool $etat_livraison_val): self {
        $this->etat_livraison_val = $etat_livraison_val;

        return $this;
    }

    public function getDateComptabilite(): ?\DateTimeInterface {
        return $this->date_comptabilite;
    }

    public function setDateComptabilite(?\DateTimeInterface $date_comptabilite): self {
        $this->date_comptabilite = $date_comptabilite;

        return $this;
    }

    public function getEtatComptabilite(): ?bool {
        return $this->etat_comptabilite;
    }

    public function setEtatComptabilite(bool $etat_comptabilite): self {
        $this->etat_comptabilite = $etat_comptabilite;

        return $this;
    }

    public function getTypeEtat(): ?string {
        return $this->type_etat;
    }

    public function setTypeEtat(string $type_etat): self {
        $this->type_etat = $type_etat;

        return $this;
    }

    public function getDateVal(): ?\DateTimeInterface {
        return $this->date_val;
    }

    public function setDateVal(?\DateTimeInterface $date_val): self {
        $this->date_val = $date_val;

        return $this;
    }

    public function getEtatProprio(): ?bool {
        return $this->etat_proprio;
    }

    public function setEtatProprio(bool $etat_proprio): self {
        $this->etat_proprio = $etat_proprio;

        return $this;
    }

}
