<?php

namespace App\Entity;

use App\Repository\MessageExterneRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MessageExterneRepository::class)
 */
class MessageExterne {

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $contacts;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $contenu;

    /**
     * @ORM\Column(type="integer")
     */
    private $type_message;

    /**
     * @ORM\ManyToOne(targetEntity=Entreprise::class, inversedBy="messageExternes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $entreprise;

    /**
     * @ORM\OneToOne(targetEntity=Historique::class, inversedBy="messageExterne", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $historique;

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
     * Constructor
     */
    public function __construct() {
        $this->etat_val = true;
        $this->etat_del = false;
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getContacts(): ?string {
        return $this->contacts;
    }

    public function setContacts(string $contacts): self {
        $this->contacts = $contacts;

        return $this;
    }

    public function getContenu(): ?string {
        return $this->contenu;
    }

    public function setContenu(string $contenu): self {
        $this->contenu = $contenu;

        return $this;
    }

    public function getTypeMessage(): ?int {
        return $this->type_message;
    }

    public function setTypeMessage(int $type_message): self {
        $this->type_message = $type_message;

        return $this;
    }

    public function getEntreprise(): ?Entreprise {
        return $this->entreprise;
    }

    public function setEntreprise(?Entreprise $entreprise): self {
        $this->entreprise = $entreprise;

        return $this;
    }

    public function getHistorique(): ?Historique {
        return $this->historique;
    }

    public function setHistorique(Historique $historique): self {
        $this->historique = $historique;

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

    public function getDateDel(): ?\DateTimeInterface
    {
        return $this->date_del;
    }

    public function setDateDel(?\DateTimeInterface $date_del): self
    {
        $this->date_del = $date_del;

        return $this;
    }

    public function getEtatVal(): ?bool
    {
        return $this->etat_val;
    }

    public function setEtatVal(bool $etat_val): self
    {
        $this->etat_val = $etat_val;

        return $this;
    }

    public function getEtatDel(): ?bool
    {
        return $this->etat_del;
    }

    public function setEtatDel(bool $etat_del): self
    {
        $this->etat_del = $etat_del;

        return $this;
    }

}
