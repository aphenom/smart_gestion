<?php

namespace App\Entity;

use App\Repository\AutreTransactionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="smartgestion_autre_transaction")
 * @ORM\Entity(repositoryClass=AutreTransactionRepository::class)
 */
class AutreTransaction {

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type_transaction;

    /**
     * @ORM\Column(type="integer")
     */
    private $montant;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $objet;

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
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="autreTransactions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user_add;

    /**
     * @ORM\ManyToOne(targetEntity=Entreprise::class, inversedBy="autreTransactions")
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

    public function getTypeTransaction(): ?string {
        return $this->type_transaction;
    }

    public function setTypeTransaction(string $type_transaction): self {
        $this->type_transaction = $type_transaction;

        return $this;
    }

    public function getUserAdd(): ?User {
        return $this->user_add;
    }

    public function setUserAdd(?User $user_add): self {
        $this->user_add = $user_add;

        return $this;
    }

    public function getMontant(): ?int {
        return $this->montant;
    }

    public function setMontant(int $montant): self {
        $this->montant = $montant;

        return $this;
    }

    public function getObjet(): ?string {
        return $this->objet;
    }

    public function setObjet(string $objet): self {
        $this->objet = $objet;

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
