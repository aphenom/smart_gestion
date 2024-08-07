<?php

namespace App\Entity;

use App\Repository\HistoriqueRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="smartgestion_historique")
 * @ORM\Entity(repositoryClass=HistoriqueRepository::class)
 */
class Historique {

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Commande::class, inversedBy="historiques")
     * @ORM\JoinColumn(nullable=false)
     */
    private $commande;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="historiques")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $etat;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $commentaire;

    /**
     * @ORM\ManyToOne(targetEntity=Entreprise::class, inversedBy="historiques")
     */
    private $entreprise;

    /**
     * @ORM\OneToOne(targetEntity=MessageExterne::class, mappedBy="historique", cascade={"persist", "remove"})
     */
    private $messageExterne;


    public function getId(): ?int {
        return $this->id;
    }

    public function getCommande(): ?Commande {
        return $this->commande;
    }

    public function setCommande(?Commande $commande): self {
        $this->commande = $commande;

        return $this;
    }

    public function getUser(): ?User {
        return $this->user;
    }

    public function setUser(?User $user): self {
        $this->user = $user;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self {
        $this->date = $date;

        return $this;
    }

    public function getEntreprise(): ?Entreprise {
        return $this->entreprise;
    }

    public function setEntreprise(?Entreprise $entreprise): self {
        $this->entreprise = $entreprise;

        return $this;
    }

    public function getCommentaire(): ?string {
        return $this->commentaire;
    }

    public function setCommentaire(?string $commentaire): self {
        $this->commentaire = $commentaire;

        return $this;
    }

    public function getEtat(): ?string {
        return $this->etat;
    }

    public function setEtat(string $etat): self {
        $this->etat = $etat;

        return $this;
    }

    public function getstep(): array {
        $etatLibelle = "";
        $etatLibelleNext = "";
        $etatCouleur = "";
        switch ($this->etat) {
            case "enregistrement":
                $etatLibelle = "Enregistrement";
                $etatLibelleNext = "Validation";
                $etatCouleur = "dark";
                break;
            case "etat_val":
                $etatLibelle = "Validation";
                $etatLibelleNext = "Lancement du LOG";
                $etatCouleur = "secondary";
                break;
            case "etat_relance":
                $etatLibelle = "Signalisation 'A relancer'";
                $etatLibelleNext = "Validation";
                $etatCouleur = "warning";
                break;
            case "etat_del":
                $etatLibelle = "Signalisation 'Annulation'";
                $etatLibelleNext = "";
                $etatCouleur = "danger";
                break;
            case "etat_lancement":
                $etatLibelle = "Lancement du LOG";
                $etatLibelleNext = "Livraison";
                $etatCouleur = "light";
                break;
            case "etat_lancement_cancel":
                $etatLibelle = "Annulation Lancement du LOG";
                $etatLibelleNext = "Lancement du LOG";
                $etatCouleur = "light";
                break;
            case "etat_livraison":
                $etatLibelle = "Livraison";
                $etatLibelleNext = "Validation Livreur";
                $etatCouleur = "primary";
                break;
            case "etat_livraison_cancel":
                $etatLibelle = "Annulation Livraison";
                $etatLibelleNext = "Livraison";
                $etatCouleur = "primary";
                break;
            case "etat_livraison_agent":
                $etatLibelle = "Validation Livreur";
                $etatLibelleNext = "Validation Livraison";
                $etatCouleur = "light";
                break;
            case "etat_livraison_agent_cancel":
                $etatLibelle = "Annulation Validation Livreur";
                $etatLibelleNext = "Validation Livreur";
                $etatCouleur = "light";
                break;
            case "etat_livraison_val":
                $etatLibelle = "Validation Livraison";
                $etatLibelleNext = "Validation Compatibilité";
                $etatCouleur = "info";
                break;
            case "etat_livraison_val_cancel":
                $etatLibelle = "Annulation Validation Livraison";
                $etatLibelleNext = "Validation Livraison";
                $etatCouleur = "info";
                break;
            case "etat_comptabilite":
                $etatLibelle = "Validation Compatibilité";
                $etatLibelleNext = "";
                $etatCouleur = "success";
                break;
            case "etat_comptabilite_cancel":
                $etatLibelle = "Annulation Validation Compatibilité";
                $etatLibelleNext = "Validation Compatibilité";
                $etatCouleur = "success";
                break;
        }
        return $step = array('etatLibelle' => $etatLibelle, 'etatLibelleNext' => $etatLibelleNext, 'etatCouleur' => $etatCouleur);
    }

    public function getMessageExterne(): ?MessageExterne
    {
        return $this->messageExterne;
    }

    public function setMessageExterne(MessageExterne $messageExterne): self
    {
        $this->messageExterne = $messageExterne;

        // set the owning side of the relation if necessary
        if ($messageExterne->getHistorique() !== $this) {
            $messageExterne->setHistorique($this);
        }

        return $this;
    }

}
