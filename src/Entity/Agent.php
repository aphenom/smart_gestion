<?php

namespace App\Entity;

use App\Repository\AgentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="smartgestion_agent")
 * @ORM\Entity(repositoryClass=AgentRepository::class)
 */
class Agent {

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
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $contact;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type_piece;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $numero_piece;

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
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="agents")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user_add;

    /**
     * @ORM\OneToMany(targetEntity=Commande::class, mappedBy="agent_livreur")
     */
    private $commandes;

        /**
     * @ORM\OneToOne(targetEntity=User::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;
    
    /**
     * @ORM\ManyToOne(targetEntity=Entreprise::class, inversedBy="agents")
     */
    private $entreprise;

    /**
     * Constructor
     */
    public function __construct() {
        $this->etat_val = true;
        $this->etat_del = false;
        $this->commandes = new ArrayCollection();
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

    public function getPrenom(): ?string {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self {
        $this->prenom = $prenom;

        return $this;
    }

    public function getContact(): ?string {
        return $this->contact;
    }

    public function setContact(string $contact): self {
        $this->contact = $contact;

        return $this;
    }

    public function getTypePiece(): ?string {
        return $this->type_piece;
    }

    public function setTypePiece(string $type_piece): self {
        $this->type_piece = $type_piece;

        return $this;
    }

    public function getLibelleTypePiece(): string {
        $type_piece = $this->type_piece;
        $lib = "";
        switch ($type_piece) {
            case "cni":
                $lib = "CNI";
                break;
            case "recepisse":
                $lib = "Récépissé";
                break;
            case "attestation":
                $lib = "Attestation";
                break;
            case "passeport":
                $lib = "Passeport";
                break;
            case "carte_sejour":
                $lib = "Carte séjour";
                break;
        }
        return $lib;
    }

    public function getNumeroPiece(): ?string {
        return $this->numero_piece;
    }

    public function setNumeroPiece(string $numero_piece): self {
        $this->numero_piece = $numero_piece;

        return $this;
    }

    public function getUserAdd(): ?User {
        return $this->user_add;
    }

    public function setUserAdd(?User $user_add): self {
        $this->user_add = $user_add;

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

    /**
     * @return Collection|Commande[]
     */
    public function getCommandes(): Collection {
        return $this->commandes;
    }

    public function addCommande(Commande $commande): self {
        if (!$this->commandes->contains($commande)) {
            $this->commandes[] = $commande;
            $commande->setAgentLivreur($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self {
        if ($this->commandes->contains($commande)) {
            $this->commandes->removeElement($commande);
            // set the owning side to null (unless already changed)
            if ($commande->getAgentLivreur() === $this) {
                $commande->setAgentLivreur(null);
            }
        }

        return $this;
    }

    public function getDisplayName(): string {
        return $this->nom . " " . $this->prenom . "  ---  " . $this->contact;
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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

}
