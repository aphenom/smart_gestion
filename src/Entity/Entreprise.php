<?php

namespace App\Entity;

use App\Repository\EntrepriseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Entity\File as EmbeddedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Table(name="smartgestion_entreprise")
 * @ORM\Entity(repositoryClass=EntrepriseRepository::class)
 * @Vich\Uploadable
 */
class Entreprise {

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * 
     * @Vich\UploadableField(mapping="product_image", fileNameProperty="logo.name", size="logo.size", mimeType="logo.mimeType", originalName="logo.originalName", dimensions="logo.dimensions")
     * 
     * @var File|null
     */
    private $imageFile;

    /**
     * @ORM\Embedded(class="Vich\UploaderBundle\Entity\File")
     *
     * @var EmbeddedFile
     */
    private $logo;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $contact;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $adresse;

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
     * @ORM\OneToMany(targetEntity=Historique::class, mappedBy="entreprise")
     */
    private $historiques;

    /**
     * @ORM\OneToMany(targetEntity=Article::class, mappedBy="entreprise")
     */
    private $articles;

    /**
     * @ORM\OneToMany(targetEntity=Commande::class, mappedBy="entreprise")
     */
    private $commandes;

    /**
     * @ORM\OneToMany(targetEntity=Agent::class, mappedBy="entreprise")
     */
    private $agents;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="entreprise")
     */
    private $users;

    /**
     * @ORM\OneToMany(targetEntity=DebitArticle::class, mappedBy="entreprise")
     */
    private $debitArticles;

    /**
     * @ORM\OneToMany(targetEntity=CreditArticle::class, mappedBy="entreprise")
     */
    private $creditArticles;

    /**
     * @ORM\OneToMany(targetEntity=CommandeArticle::class, mappedBy="entreprise")
     */
    private $commandeArticles;

    /**
     * @ORM\OneToMany(targetEntity=AutreTransaction::class, mappedBy="entreprise")
     */
    private $autreTransactions;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $api_message;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $message_1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $message_2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $message_3;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $message_4;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $message_5;

    /**
     * @ORM\OneToMany(targetEntity=MessageExterne::class, mappedBy="entreprise")
     */
    private $messageExternes;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $livraison_uniquement;

    /**
     * Constructor
     */
    public function __construct() {
        $this->etat_val = true;
        $this->etat_del = false;
        $this->historiques = new ArrayCollection();
        $this->articles = new ArrayCollection();
        $this->commandes = new ArrayCollection();
        $this->agents = new ArrayCollection();
        $this->users = new ArrayCollection();
        $this->debitArticles = new ArrayCollection();
        $this->creditArticles = new ArrayCollection();
        $this->commandeArticles = new ArrayCollection();
        $this->autreTransactions = new ArrayCollection();
        $this->logo = new EmbeddedFile();
        $this->messageExternes = new ArrayCollection();
        $this->livraison_uniquement = false;
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getNom(): ?string {
        return $this->nom;
    }

    public function setNom(string $nom): self {
        $this->nom = $nom;

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

    public function getLogo(): ?EmbeddedFile {
        return $this->logo;
    }

    public function setLogo(EmbeddedFile $logo): self {
        $this->logo = $logo;

        return $this;
    }

    public function getContact(): ?string {
        return $this->contact;
    }

    public function setContact(?string $contact): self {
        $this->contact = $contact;

        return $this;
    }

    public function getAdresse(): ?string {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): self {
        $this->adresse = $adresse;

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
            $historique->setEntreprise($this);
        }

        return $this;
    }

    public function removeHistorique(Historique $historique): self {
        if ($this->historiques->contains($historique)) {
            $this->historiques->removeElement($historique);
            // set the owning side to null (unless already changed)
            if ($historique->getEntreprise() === $this) {
                $historique->setEntreprise(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Article[]
     */
    public function getArticles(): Collection {
        return $this->articles;
    }

    public function addArticle(Article $article): self {
        if (!$this->articles->contains($article)) {
            $this->articles[] = $article;
            $article->setEntreprise($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): self {
        if ($this->articles->contains($article)) {
            $this->articles->removeElement($article);
            // set the owning side to null (unless already changed)
            if ($article->getEntreprise() === $this) {
                $article->setEntreprise(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Commande[]
     */
    public function getCommandes(): Collection {
        return $this->commandes;
    }

    public function addCommande(Commande $commande): self {
        if (!$this->commandes->contains($commande)) {
            $this->commandes[] = $commande;
            $commande->setEntreprise($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self {
        if ($this->commandes->contains($commande)) {
            $this->commandes->removeElement($commande);
            // set the owning side to null (unless already changed)
            if ($commande->getEntreprise() === $this) {
                $commande->setEntreprise(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Agent[]
     */
    public function getAgents(): Collection {
        return $this->agents;
    }

    public function addAgent(Agent $agent): self {
        if (!$this->agents->contains($agent)) {
            $this->agents[] = $agent;
            $agent->setEntreprise($this);
        }

        return $this;
    }

    public function removeAgent(Agent $agent): self {
        if ($this->agents->contains($agent)) {
            $this->agents->removeElement($agent);
            // set the owning side to null (unless already changed)
            if ($agent->getEntreprise() === $this) {
                $agent->setEntreprise(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection {
        return $this->users;
    }

    public function addUser(User $user): self {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setEntreprise($this);
        }

        return $this;
    }

    public function removeUser(User $user): self {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            // set the owning side to null (unless already changed)
            if ($user->getEntreprise() === $this) {
                $user->setEntreprise(null);
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
            $debitArticle->setEntreprise($this);
        }

        return $this;
    }

    public function removeDebitArticle(DebitArticle $debitArticle): self {
        if ($this->debitArticles->contains($debitArticle)) {
            $this->debitArticles->removeElement($debitArticle);
            // set the owning side to null (unless already changed)
            if ($debitArticle->getEntreprise() === $this) {
                $debitArticle->setEntreprise(null);
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
            $creditArticle->setEntreprise($this);
        }

        return $this;
    }

    public function removeCreditArticle(CreditArticle $creditArticle): self {
        if ($this->creditArticles->contains($creditArticle)) {
            $this->creditArticles->removeElement($creditArticle);
            // set the owning side to null (unless already changed)
            if ($creditArticle->getEntreprise() === $this) {
                $creditArticle->setEntreprise(null);
            }
        }

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
            $commandeArticle->setEntreprise($this);
        }

        return $this;
    }

    public function removeCommandeArticle(CommandeArticle $commandeArticle): self {
        if ($this->commandeArticles->contains($commandeArticle)) {
            $this->commandeArticles->removeElement($commandeArticle);
            // set the owning side to null (unless already changed)
            if ($commandeArticle->getEntreprise() === $this) {
                $commandeArticle->setEntreprise(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|AutreTransaction[]
     */
    public function getAutreTransactions(): Collection {
        return $this->autreTransactions;
    }

    public function addAutreTransaction(AutreTransaction $autreTransaction): self {
        if (!$this->autreTransactions->contains($autreTransaction)) {
            $this->autreTransactions[] = $autreTransaction;
            $autreTransaction->setEntreprise($this);
        }

        return $this;
    }

    public function removeAutreTransaction(AutreTransaction $autreTransaction): self {
        if ($this->autreTransactions->contains($autreTransaction)) {
            $this->autreTransactions->removeElement($autreTransaction);
            // set the owning side to null (unless already changed)
            if ($autreTransaction->getEntreprise() === $this) {
                $autreTransaction->setEntreprise(null);
            }
        }

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

    public function getUpdatedAt(): ?\DateTimeInterface {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function stats(User $user = null, string $debut = null, string $fin = null) {
        if ($debut != null && new \DateTime($debut)) {
            $debut = new \DateTime($debut); //->format("m-Y");
        }
        if ($fin != null &&  new \DateTime($fin)) {
            $fin = new \DateTime($fin); //->format("m-Y");
        }

        $user_val = 0;
        $user_non_val = 0;
        $user_del = 0;
        $user_lancement = 0;
        $user_livraison = 0;
        $user_livraison_agent = 0;
        $user_livraison_val = 0;
        $user_comptabilite = 0;
        $user_relance = 0;
        $user_delete = 0;

        $etat_val = 0;
        $etat_non_val = 0;
        $etat_del = 0;
        $etat_lancement = 0;
        $etat_livraison = 0;
        $etat_livraison_agent = 0;
        $etat_livraison_val = 0;
        $etat_comptabilite = 0;
        $relance = 0;
        $delete = 0;

        $livreur = 0;

        $ca = 0;
        $traite = 0;


        $nbreAttenteReglement = 0;
        $montantAttenteReglement = 0;
        $nbreReglement = 0;
        $montantReglement = 0;
        $montantVentes = 0;
        $montantLivraisons = 0;
        $montantAchats = 0;

        $commandeLogAttente = 0;
        $commandeLivraisonAttente = 0;
        $commandeLivraisonCours = 0;
        $commandeLivraisonAgent = 0;

        $commandeAnnule = 0;
        $commandeNonValide = 0;
        $commandeLivraisonValide = 0;
        $commandeComptabilite = 0;
        $commandeArticleEncours = 0;
        $commandeArticleVenteInterne = 0;
        $commandeArticleVenteExterne = 0;
        $articleReapprovisonnement = 0;

        foreach ($this->commandes as $commande) {

            $initCa = 0;
            $initTraite = 0;

            if ($commande->getEtatLivraison() == true && $commande->getAgentLivreur()->getUser() == $user) {
                $livreur++;
            }

            foreach ($commande->getHistoriques() as $historique) {

                if ($commande->getEtatVal() == true) {
                    $statHistorique = $this->statsHistorique($historique, "etat_val", $commande->getDateVal(), $debut, $fin, $user);
                    $user_val += $statHistorique["user_historique"];
                    $etat_val += $statHistorique["etat_historique"];
                    $initCa == 0 ? $initCa += $statHistorique["ca"] : $initCa;
                    $initTraite == 0 ? $initTraite += $statHistorique["traite"] : $initTraite;
                }

                if ($commande->getEtatLancement() == true) {
                    $statHistorique = $this->statsHistorique($historique, "etat_lancement", $commande->getDateLancement(), $debut, $fin, $user);
                    $user_lancement += $statHistorique["user_historique"];
                    $etat_lancement += $statHistorique["etat_historique"];
                    $initCa == 0 ? $initCa += $statHistorique["ca"] : $initCa;
                    $initTraite == 0 ? $initTraite += $statHistorique["traite"] : $initTraite;
                }

                if ($commande->getEtatLivraison() == true) {
                    $statHistorique = $this->statsHistorique($historique, "etat_livraison", $commande->getDateLivraison(), $debut, $fin, $user);
                    $user_livraison += $statHistorique["user_historique"];
                    $etat_livraison += $statHistorique["etat_historique"];
                    $initCa == 0 ? $initCa += $statHistorique["ca"] : $initCa;
                    $initTraite == 0 ? $initTraite += $statHistorique["traite"] : $initTraite;
                }

                if ($commande->getEtatLivraisonAgent() == true) {
                    $statHistorique = $this->statsHistorique($historique, "etat_livraison_agent", $commande->getDateLivraisonAgent(), $debut, $fin, $user);
                    $user_livraison_agent += $statHistorique["user_historique"];
                    $etat_livraison_agent += $statHistorique["etat_historique"];
                    $initCa == 0 ? $initCa += $statHistorique["ca"] : $initCa;
                    $initTraite == 0 ? $initTraite += $statHistorique["traite"] : $initTraite;
                }

                if ($commande->getEtatLivraisonVal() == true) {
                    $statHistorique = $this->statsHistorique($historique, "etat_livraison_val", $commande->getDateLivraisonVal(), $debut, $fin, $user);
                    $user_livraison_val += $statHistorique["user_historique"];
                    $etat_livraison_val += $statHistorique["etat_historique"];
                }

                if ($commande->getEtatComptabilite() == true) {
                    $statHistorique = $this->statsHistorique($historique, "etat_comptabilite", $commande->getDateComptabilite(), $debut, $fin, $user);
                    $user_comptabilite += $statHistorique["user_historique"];
                    $etat_comptabilite += $statHistorique["etat_historique"];
                    $initCa == 0 ? $initCa += $statHistorique["ca"] : $initCa;
                    $initTraite == 0 ? $initTraite += $statHistorique["traite"] : $initTraite;
                }

                if ($commande->getEtatDel() == true) {
                    $statHistorique = $this->statsHistorique($historique, "etat_del", $commande->getDateDel(), $debut, $fin, $user);
                    $user_del += $statHistorique["user_historique"];
                    $etat_del += $statHistorique["etat_historique"];
                }

                if ($commande->getEtatVal() == false && $commande->getEtatRelance() == false && $commande->getEtatDel() == false) {
                    if ($debut != null && $fin != null && $commande->getDateAdd() >= $debut && $commande->getDateAdd() <= $fin) {
                        if ($user != null && $commande->getUserAdd() == $user) {
                            $user_non_val++;
                        } elseif ($user == null) {
                            $etat_non_val++;
                        }
                    } elseif ($debut == null && $fin == null) {
                        if ($user != null && $commande->getUserAdd() == $user) {
                            $user_non_val++;
                        } elseif ($user == null) {
                            $etat_non_val++;
                        }
                    }
                }



                if ($historique->getEtat() == "etat_relance") {
                    if ($debut != null && $fin != null && $historique->getDate() >= $debut && $historique->getDate() <= $fin) {
                        if ($user != null && $historique->getUser() == $user) {
                            $user_relance++;
                        } elseif ($user == null) {
                            $relance++;
                        }
                    } elseif ($debut == null && $fin == null) {
                        if ($user != null && $historique->getUser() == $user) {
                            $user_relance++;
                        } elseif ($user == null) {
                            $relance++;
                        }
                    }
                }

                if ($historique->getEtat() == "etat_del") {
                    if ($debut != null && $fin != null && $historique->getDate() >= $debut && $historique->getDate() <= $fin) {
                        if ($user != null && $historique->getUser() == $user) {
                            $user_delete++;
                        } elseif ($user == null) {
                            $delete++;
                        }
                    } elseif ($debut == null && $fin == null) {
                        if ($user != null && $historique->getUser() == $user) {
                            $user_delete++;
                        } elseif ($user == null) {
                            $delete++;
                        }
                    }
                }
            }

            if (($debut != null && $fin != null && $commande->getDateVal() >= $debut && $commande->getDateVal() <= $fin) || ($debut == null && $fin == null)) {
                $ca += $initCa;
                $traite += $initTraite;
            }


            if (($commande->getEtatLancement() == true && $commande->getEtatComptabilite() != true) && (($debut != null && $fin != null && $commande->getDateLancement() >= $debut && $commande->getDateLancement() <= $fin) || ($debut == null && $fin == null))) {
                $nbreAttenteReglement++;
                $montantAttenteReglement += $commande->getTotal();
                $montantVentes += $commande->getTotalCommandeArticle();
                $montantAchats += $commande->getAchatCommandeArticle();
                $montantLivraisons += $commande->getFraisLivraison();
            }

            if ($commande->getEtatVal() == false && $commande->getEtatRelance() == false && $commande->getEtatDel() == false) {
                $commandeNonValide++;
            }

            if ($commande->getEtatComptabilite() == true && (($debut != null && $fin != null && $commande->getDateComptabilite() >= $debut && $commande->getDateComptabilite() <= $fin) || ($debut == null && $fin == null))) {

                $commandeComptabilite++;

                $nbreReglement++;
                $montantReglement += $commande->getTotal();
                $montantVentes += $commande->getTotalCommandeArticle();
                $montantAchats += $commande->getAchatCommandeArticle();
                $montantLivraisons += $commande->getFraisLivraison();
            }

            if ($commande->getEtatLivraisonVal() == true) {
                $commandeLivraisonValide++;
            }

            if ($commande->getEtat()["etat"] == "del") {
                $commandeAnnule++;
            }
            if ($commande->getEtat()["etat"] == "val") {
                $commandeLogAttente++;
            }
            if ($commande->getEtat()["etat"] == "lancement") {
                $commandeLivraisonAttente++;
            }
            if ($commande->getEtat()["etat"] == "livraison") {
                $commandeLivraisonCours++;
            }
            if ($commande->getEtat()["etat"] == "livraison-agent") {
                $commandeLivraisonAgent++;
            }

            foreach ($this->commandeArticles as $commandeArticle) {
                if ($commande->getEtatLancement() == true && $commande->getEtatComptabilite() != true && $commandeArticle->getEtatVal() == true && $commandeArticle->getEtatDel() == false) {
                    $commandeArticleEncours += $commandeArticle->getQuantite();
                }
                if ($commande->getEtatComptabilite() == true && $commandeArticle->getEtatVal() == true && $commandeArticle->getEtatDel() == false) {
                    if ($commandeArticle->getArticle()->getEtatProprio() == true) {
                        $commandeArticleVenteInterne += $commandeArticle->getQuantite();
                    } else {
                        $commandeArticleVenteExterne += $commandeArticle->getQuantite();
                    }
                }
            }
        }

        $nombreAgents = 0;
        foreach ($this->agents as $agent) {
            if ($agent->getEtatVal() == true && $agent->getEtatDel() == false) {
                $nombreAgents++;
            }
        }

        $achatArticle = 0;
        $nbreArticleReapprovisionnement = 0;
        foreach ($this->articles as $article) {
            $achatArticle += $article->getPuAchat() * $article->getQuantiteCredit();
            if ($article->getQuantiteStock() < $article->getSeuilApprovisionnement()) {
                $nbreArticleReapprovisionnement++;
            }
        }

        $montantEntrees = 0;
        $montantSorties = 0;
        foreach ($this->autreTransactions as $autreTransaction) {
            if ($autreTransaction->getTypeTransaction() == "entree" && $autreTransaction->getEtatVal() == true && $autreTransaction->getEtatDel() == false) {
                $montantEntrees += $autreTransaction->getMontant();
            }
            if ($autreTransaction->getTypeTransaction() == "sortie" && $autreTransaction->getEtatVal() == true && $autreTransaction->getEtatDel() == false) {
                $montantSorties += $autreTransaction->getMontant();
            }
        }


        return array(
            "user_val" => $user_val,
            "user_non_val" => $user_non_val,
            "user_del" => $user_del,
            "user_lancement" => $user_lancement,
            "user_livraison" => $user_livraison,
            "user_livraison_agent" => $user_livraison_agent,
            "user_livraison_val" => $user_livraison_val,
            "user_comptabilite" => $user_comptabilite,
            "user_relance" => $user_relance,
            "user_delete" => $user_delete,
            "etat_val" => $etat_val,
            "etat_non_val" => $etat_non_val,
            "etat_del" => $etat_del,
            "etat_lancement" => $etat_lancement,
            "etat_livraison" => $etat_livraison,
            "etat_livraison_agent" => $etat_livraison_agent,
            "etat_livraison_val" => $etat_livraison_val,
            "etat_comptabilite" => $etat_comptabilite,
            "relance" => $relance,
            "delete" => $delete,
            "livreur" => $livreur,
            "ca" => $ca,
            "traite" => $traite,
            //'number' => $number,
            'nombreAgents' => $nombreAgents,
            'montantEntrees' => $montantEntrees,
            'montantSorties' => $montantSorties,
            'commandeAnnule' => $commandeAnnule,
            'commandeNonValide' => $commandeNonValide,
            'commandeLogAttente' => $commandeLogAttente,
            'commandeLivraisonAttente' => $commandeLivraisonAttente,
            'commandeLivraisonCours' => $commandeLivraisonCours,
            'commandeLivraisonAgent' => $commandeLivraisonAgent,
            'commandeLivraisonValide' => $commandeLivraisonValide,
            'commandeComptabilite' => $commandeComptabilite,
            'commandeArticleEncours' => $commandeArticleEncours,
            'commandeArticleVenteInterne' => $commandeArticleVenteInterne,
            'commandeArticleVenteExterne' => $commandeArticleVenteExterne,
            'articleReapprovisonnement' => $articleReapprovisonnement,
            'nbreAttenteReglement' => $nbreAttenteReglement,
            'montantAttenteReglement' => $montantAttenteReglement,
            'nbreReglement' => $nbreReglement,
            'montantReglement' => $montantReglement,
            'montantVentes' => $montantVentes,
            'montantAchats' => $montantAchats,
            'montantLivraisons' => $montantLivraisons,
            'achatArticle' => $achatArticle,
        );
    }

    public function statsHistorique(Historique $historique, string $etat, ?\DateTime $etatDate, ?\DateTime $debut, ?\DateTime $fin, ?User $user) {
        $user_historique = 0;
        $etat_historique = 0;
        $ca = 0;
        $traite = 0;

        if ($historique->getEtat() == $etat && $historique->getDate() == $etatDate) {
            if ($debut != null && $fin != null && $historique->getDate() >= $debut && $historique->getDate() <= $fin) {
                if ($user != null && $historique->getUser() == $user) {
                    $user_historique++;
                    $ca = $historique->getCommande()->getTotal();
                    $traite++;
                } elseif ($user == null) {
                    $etat_historique++;
                    $ca = $historique->getCommande()->getTotal();
                    $traite++;
                }
            } elseif ($debut == null && $fin == null) {
                if ($user != null && $historique->getUser() == $user) {
                    $user_historique++;
                    $ca = $historique->getCommande()->getTotal();
                    $traite++;
                } elseif ($user == null) {
                    $etat_historique++;
                    $ca = $historique->getCommande()->getTotal();
                    $traite++;
                }
            }
        }

        return array("user_historique" => $user_historique, "etat_historique" => $etat_historique, "ca" => $ca, "traite" => $traite);
    }

    public function getApiMessage(): ?string
    {
        return $this->api_message;
    }

    public function setApiMessage(?string $api_message): self
    {
        $this->api_message = $api_message;

        return $this;
    }

    public function getMessage1(): ?string
    {
        return $this->message_1;
    }

    public function setMessage1(?string $message_1): self
    {
        $this->message_1 = $message_1;

        return $this;
    }

    public function getMessage2(): ?string
    {
        return $this->message_2;
    }

    public function setMessage2(?string $message_2): self
    {
        $this->message_2 = $message_2;

        return $this;
    }

    public function getMessage3(): ?string
    {
        return $this->message_3;
    }

    public function setMessage3(?string $message_3): self
    {
        $this->message_3 = $message_3;

        return $this;
    }

    public function getMessage4(): ?string
    {
        return $this->message_4;
    }

    public function setMessage4(?string $message_4): self
    {
        $this->message_4 = $message_4;

        return $this;
    }

    public function getMessage5(): ?string
    {
        return $this->message_5;
    }

    public function setMessage5(?string $message_5): self
    {
        $this->message_5 = $message_5;

        return $this;
    }

    /**
     * @return Collection|MessageExterne[]
     */
    public function getMessageExternes(): Collection
    {
        return $this->messageExternes;
    }

    public function addMessageExterne(MessageExterne $messageExterne): self
    {
        if (!$this->messageExternes->contains($messageExterne)) {
            $this->messageExternes[] = $messageExterne;
            $messageExterne->setEntreprise($this);
        }

        return $this;
    }

    public function removeMessageExterne(MessageExterne $messageExterne): self
    {
        if ($this->messageExternes->contains($messageExterne)) {
            $this->messageExternes->removeElement($messageExterne);
            // set the owning side to null (unless already changed)
            if ($messageExterne->getEntreprise() === $this) {
                $messageExterne->setEntreprise(null);
            }
        }

        return $this;
    }

    public function getLivraisonUniquement(): ?bool
    {
        return $this->livraison_uniquement;
    }

    public function setLivraisonUniquement(?bool $livraison_uniquement): self
    {
        $this->livraison_uniquement = $livraison_uniquement;

        return $this;
    }

}
