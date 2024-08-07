<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Table(name="smartgestion_user")
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface {

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="array")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

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
     * @ORM\Column(type="string", length=255)
     */
    private $text_password;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $contact;

    /**
     * @ORM\OneToMany(targetEntity=Agent::class, mappedBy="user_add")
     */
    private $agents;

    /**
     * @ORM\OneToMany(targetEntity=Article::class, mappedBy="user_add")
     */
    private $article_adds;

    /**
     * @ORM\OneToMany(targetEntity=Article::class, mappedBy="user_del")
     */
    private $article_dels;

    /**
     * @ORM\OneToMany(targetEntity=Article::class, mappedBy="user_val")
     */
    private $article_vals;

    /**
     * @ORM\OneToMany(targetEntity=Commande::class, mappedBy="user_add")
     */
    private $commande_adds;

    /**
     * @ORM\OneToMany(targetEntity=Commande::class, mappedBy="user_montant")
     */
    private $commande_montants;

    /**
     * @ORM\OneToMany(targetEntity=CreditArticle::class, mappedBy="user_add")
     */
    private $creditArticles;

    /**
     * @ORM\OneToMany(targetEntity=DebitArticle::class, mappedBy="user_add")
     */
    private $debitArticles;

    /**
     * @ORM\OneToMany(targetEntity=AutreTransaction::class, mappedBy="user_add")
     */
    private $autreTransactions;

    /**
     * @ORM\OneToMany(targetEntity=Historique::class, mappedBy="user")
     */
    private $historiques;

    /**
     * @ORM\ManyToOne(targetEntity=Entreprise::class, inversedBy="users")
     */
    private $entreprise;

    /**
     * Constructor
     */
    public function __construct() {
//$this->dateAdd 
        $this->etat_val = true;
        $this->etat_del = false;
        $this->agents = new ArrayCollection();
        $this->article_adds = new ArrayCollection();
        $this->article_dels = new ArrayCollection();
        $this->article_vals = new ArrayCollection();
        $this->commande_adds = new ArrayCollection();
        $this->commande_montants = new ArrayCollection();
        $this->creditArticles = new ArrayCollection();
        $this->debitArticles = new ArrayCollection();
        $this->autreTransactions = new ArrayCollection();
        ;
        //$this->roles = array("ROLE_USER");
        //$this->setUsername($this->generateurCode(2, true) . date_format(new \DateTime(), 'His'));
        //$this->setPassword($this->generateurCode(6, null));
        // $this->souscripteur_dettes = new ArrayCollection();
        // $this->responsable_tontines = new ArrayCollection();
        // $this->souscripteur_participations = new ArrayCollection();
        // $this->superviseur_versements = new ArrayCollection();
        // $this->souscripteur_transactions = new ArrayCollection();
        // $this->superviseur_transactions = new ArrayCollection();
        // $this->souscripteur_versements = new ArrayCollection();

        $this->historiques = new ArrayCollection();
    }

    public function getId(): ?int {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string {
        return (string) $this->username;
    }

    public function setUsername(string $username): self {
        $this->username = $username;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        //$roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self {
        $this->roles = $roles;

        return $this;
    }

    public function getLibelleRoles(): string {
        $roles = $this->roles;
        $lib_roles = "";
        $lib = "";
        foreach ($roles as $v) {
            //echo "Valeur courante de \$a: $v.\n";
            switch ($v) {
                case "ROLE_COM":
                    $lib = "Commercial";
                    break;
                case "ROLE_LOG":
                    $lib = "Logisticien";
                    break;
                case "ROLE_LIV":
                    $lib = "Livraison";
                    break;
                case "ROLE_AGENT":
                    $lib = "Agent Livreur";
                    break;
                case "ROLE_FIN":
                    $lib = "Comptable";
                    break;
                case "ROLE_ADMIN":
                    $lib = "Administrateur";
                    break;
//                case "ROLE_SUPER":
//                    $lib = "Super Administrateur";
//                    break;
            }
            $lib_roles .= $lib . " ";
        }

        return $lib_roles;
    }

    public function getDisplayName(): string {
        return $this->username . "  ---  " . $this->nom . " " . $this->prenom;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string {
        return (string) $this->password;
    }

    public function setPassword(string $password): self {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt() {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials() {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function getTextPassword(): ?string {
        return $this->text_password;
    }

    public function setTextPassword(string $text_password): self {
        $this->text_password = $text_password;

        return $this;
    }

    public function getEmail(): ?string {
        return $this->email;
    }

    public function setEmail(?string $email): self {
        $this->email = $email;

        return $this;
    }

    public function getContact(): ?string {
        return $this->contact;
    }

    public function setContact(?string $contact): self {
        $this->contact = $contact;

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
            $agent->setUserAdd($this);
        }

        return $this;
    }

    public function removeAgent(Agent $agent): self {
        if ($this->agents->contains($agent)) {
            $this->agents->removeElement($agent);
            // set the owning side to null (unless already changed)
            if ($agent->getUserAdd() === $this) {
                $agent->setUserAdd(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Article[]
     */
    public function getArticleAdds(): Collection {
        return $this->article_adds;
    }

    public function addArticleAdd(Article $articleAdd): self {
        if (!$this->article_adds->contains($articleAdd)) {
            $this->article_adds[] = $articleAdd;
            $articleAdd->setUserAdd($this);
        }

        return $this;
    }

    public function removeArticleAdd(Article $articleAdd): self {
        if ($this->article_adds->contains($articleAdd)) {
            $this->article_adds->removeElement($articleAdd);
            // set the owning side to null (unless already changed)
            if ($articleAdd->getUserAdd() === $this) {
                $articleAdd->setUserAdd(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Article[]
     */
    public function getArticleDels(): Collection {
        return $this->article_dels;
    }

    public function addArticleDel(Article $articleDel): self {
        if (!$this->article_dels->contains($articleDel)) {
            $this->article_dels[] = $articleDel;
            $articleDel->setUserDel($this);
        }

        return $this;
    }

    public function removeArticleDel(Article $articleDel): self {
        if ($this->article_dels->contains($articleDel)) {
            $this->article_dels->removeElement($articleDel);
            // set the owning side to null (unless already changed)
            if ($articleDel->getUserDel() === $this) {
                $articleDel->setUserDel(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Article[]
     */
    public function getArticleVals(): Collection {
        return $this->article_vals;
    }

    public function addArticleVal(Article $articleVal): self {
        if (!$this->article_vals->contains($articleVal)) {
            $this->article_vals[] = $articleVal;
            $articleVal->setUserVal($this);
        }

        return $this;
    }

    public function removeArticleVal(Article $articleVal): self {
        if ($this->article_vals->contains($articleVal)) {
            $this->article_vals->removeElement($articleVal);
            // set the owning side to null (unless already changed)
            if ($articleVal->getUserVal() === $this) {
                $articleVal->setUserVal(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Commande[]
     */
    public function getCommandeAdds(): Collection {
        return $this->commande_adds;
    }

    public function addCommandeAdd(Commande $commandeAdd): self {
        if (!$this->commande_adds->contains($commandeAdd)) {
            $this->commande_adds[] = $commandeAdd;
            $commandeAdd->setUserAdd($this);
        }

        return $this;
    }

    public function removeCommandeAdd(Commande $commandeAdd): self {
        if ($this->commande_adds->contains($commandeAdd)) {
            $this->commande_adds->removeElement($commandeAdd);
            // set the owning side to null (unless already changed)
            if ($commandeAdd->getUserAdd() === $this) {
                $commandeAdd->setUserAdd(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Commande[]
     */
    public function getCommandeMontants(): Collection {
        return $this->commande_montants;
    }

    public function addCommandeMontant(Commande $commandeMontant): self {
        if (!$this->commande_montants->contains($commandeMontant)) {
            $this->commande_montants[] = $commandeMontant;
            $commandeMontant->setUserMontant($this);
        }

        return $this;
    }

    public function removeCommandeMontant(Commande $commandeMontant): self {
        if ($this->commande_montants->contains($commandeMontant)) {
            $this->commande_montants->removeElement($commandeMontant);
            // set the owning side to null (unless already changed)
            if ($commandeMontant->getUserMontant() === $this) {
                $commandeMontant->setUserMontant(null);
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
            $creditArticle->setUserAdd($this);
        }

        return $this;
    }

    public function removeCreditArticle(CreditArticle $creditArticle): self {
        if ($this->creditArticles->contains($creditArticle)) {
            $this->creditArticles->removeElement($creditArticle);
            // set the owning side to null (unless already changed)
            if ($creditArticle->getUserAdd() === $this) {
                $creditArticle->setUserAdd(null);
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
            $debitArticle->setUserAdd($this);
        }

        return $this;
    }

    public function removeDebitArticle(DebitArticle $debitArticle): self {
        if ($this->debitArticles->contains($debitArticle)) {
            $this->debitArticles->removeElement($debitArticle);
            // set the owning side to null (unless already changed)
            if ($debitArticle->getUserAdd() === $this) {
                $debitArticle->setUserAdd(null);
            }
        }

        return $this;
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

    /**
     * @return Collection|AutreTransaction[]
     */
    public function getAutreTransactions(): Collection {
        return $this->autreTransactions;
    }

    public function addAutreTransaction(AutreTransaction $autreTransaction): self {
        if (!$this->autreTransactions->contains($autreTransaction)) {
            $this->autreTransactions[] = $autreTransaction;
            $autreTransaction->setUserAdd($this);
        }

        return $this;
    }

    public function removeAutreTransaction(AutreTransaction $autreTransaction): self {
        if ($this->autreTransactions->contains($autreTransaction)) {
            $this->autreTransactions->removeElement($autreTransaction);
            // set the owning side to null (unless already changed)
            if ($autreTransaction->getUserAdd() === $this) {
                $autreTransaction->setUserAdd(null);
            }
        }

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
            $historique->setUser($this);
        }

        return $this;
    }

    public function removeHistorique(Historique $historique): self {
        if ($this->historiques->contains($historique)) {
            $this->historiques->removeElement($historique);
            // set the owning side to null (unless already changed)
            if ($historique->getUser() === $this) {
                $historique->setUser(null);
            }
        }

        return $this;
    }

    public function getEntreprise(): ?Entreprise {
        return $this->entreprise;
    }

    public function setEntreprise(?Entreprise $entreprise): self {
        $this->entreprise = $entreprise;

        return $this;
    }

}
