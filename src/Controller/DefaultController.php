<?php

// src/Controller/DefaultController.php

namespace App\Controller;

use App\Repository\CommandeRepository;
use App\Repository\ArticleRepository;
use App\Repository\CommandeArticleRepository;
use App\Repository\AgentRepository;
use App\Repository\AutreTransactionRepository;
use App\Repository\DebitArticleRepository;
use App\Repository\CreditArticleRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
/* use App\Repository\DetteRepository;
  use App\Repository\TransactionRepository;
  use App\Controller\DetteController;
  use App\Controller\TransactionController;
  use App\Entity\User;
  use App\Entity\Participation;
  use App\Entity\Dette;
  use CinetPay\CinetPay;
  use App\Entity\Transaction;
  use App\Repository\FraisMobileRepository; */
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class DefaultController extends AbstractController {

    /**
     * @Route("/", name="dashboard")
     */
    public function index(AgentRepository $agentRepository, ArticleRepository $articleRepository, CommandeRepository $commandeRepository, CommandeArticleRepository $commandeArticleRepository, AutreTransactionRepository $autreTransactionRepository, DebitArticleRepository $debitArticleRepository, CreditArticleRepository $creditArticleRepository) {
        $number = random_int(0, 100);
        /*
          $nombreAgents = $agentRepository->myCount();
          $montantEntrees = $autreTransactionRepository->montantEntrees();
          $montantSorties = $autreTransactionRepository->montantSorties();
          $commandeNonValide = $commandeRepository->nonValide();
          $commandeLivraisonAttente = $commandeRepository->livraisonAttente();
          $commandeLivraisonCours = $commandeRepository->livraisonCours();
          $commandeLivraisonRetour = $commandeRepository->livraisonRetour();
          $commandeLivraisonReception = $commandeRepository->livraisonReception();
          $commandeArticleEncours = $commandeArticleRepository->enCours(null);
          $commandeArticleVenteInterne = $commandeArticleRepository->venteInterne(null);
          $commandeArticleVenteExterne = $commandeArticleRepository->venteExterne();
          $articleReapprovisonnement = $this->articleReapprovisonnement($articleRepository);
          $nbreAttenteReglement = $this->commandeReglement($commandeRepository)["nbreAttenteReglement"];
          $montantAttenteReglement = $this->commandeReglement($commandeRepository)["montantAttenteReglement"];
          $nbreReglement = $this->commandeReglement($commandeRepository)["nbreReglement"];
          $montantReglement = $this->commandeReglement($commandeRepository)["montantReglement"];
          $montantVentes = $this->commandeReglement($commandeRepository)["montantVentes"];
          $montantAchats = $this->commandeReglement($commandeRepository)["montantAchats"];
          $montantLivraisons = $this->commandeReglement($commandeRepository)["montantLivraisons"];
          $achatArticle = $this->achatArticle($articleRepository);

          return $this->render('default/index.html.twig', [
          'number' => $number,
          'nombreAgents' => $nombreAgents,
          'montantEntrees' => $montantEntrees,
          'montantSorties' => $montantSorties,
          'commandeNonValide' => $commandeNonValide,
          'commandeLivraisonAttente' => $commandeLivraisonAttente,
          'commandeLivraisonCours' => $commandeLivraisonCours,
          'commandeLivraisonRetour' => $commandeLivraisonRetour,
          'commandeLivraisonReception' => $commandeLivraisonReception,
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
          ]);
         */

        return $this->render('default/index.html.twig', [
                        //'commandes' => $commandes,
        ]);
    }

    /**
     * @Route("/{filtre}/commande/{type}", name="dashboard_filtre_commande", methods={"GET"})
     */

    public function commande(Request $request, string $filtre, string $type, CommandeRepository $commandeRepository): Response {
        switch ($filtre) {
            case "listeNonValide":
                $commandes = $commandeRepository->listeNonValide();
                break;
            case "listeLivraisonAttente":
                $commandes = $commandeRepository->listeLivraisonAttente();
                break;
            case "listeLivraisonCours":
                $commandes = $commandeRepository->listeLivraisonCours();
                break;
            case "listeLivraisonRetour":
                $commandes = $commandeRepository->listeLivraisonRetour();
                break;
            case "listeLivraisonReception":
                $commandes = $commandeRepository->listeLivraisonReception();
                break;
        }

        switch ($type) {
            case "commercial":
                $retour = $this->render('commande/index.html.twig', [
                    'commandes' => $commandes,
                ]);
                break;
            case "logistic":
                $retour = $this->render('commande/index_logistic.html.twig', [
                    'commandes' => $commandes,
                ]);
                break;
            case "comptable":
                $retour = $this->render('commande/index_comptable.html.twig', [
                    'commandes' => $commandes,
                ]);
                break;
        }
        //        var_dump($type);
        //        exit;
        return $retour;
    }

    /**
     * @Route("/{filtre}/article/{type}", name="dashboard_filtre_article", methods={"GET"})
     */
    public function article(Request $request, string $filtre, string $type, CommandeArticleRepository $commandeArticleRepository): Response {
        switch ($filtre) {
            case "listeEnCours":
                $commandeArticles = $commandeArticleRepository->listeEnCours(null);
                break;
            case "listeVenteInterne":
                $commandeArticles = $commandeArticleRepository->listeVenteInterne(null);
                break;
        }

        return $this->render('article/index_commande_article.html.twig', [
                    'commandeArticles' => $commandeArticles,
        ]);
    }

    /*
     * * Fonction pour une chaîne aléatoire de chiffres */

    public function random_number($nbr) {
        $str = "";
        $chaine = "0123456789";
        $nb_chars = strlen($chaine);

        for ($i = 0; $i < $nbr; $i++) {
            $str .= $chaine[rand(0, ($nb_chars - 1))];
        }

        return $str;
    }

    private function articleReapprovisonnement(ArticleRepository $articleRepository): int {
        $articles = $articleRepository->findBy(array('etat_val' => true, 'etat_del' => false));
        $nbreArticleReapprovisionnement = 0;
        foreach ($articles as $article) {
            /* $quantiteAchatEncours = $commandeArticleRepository->enCours($article);
              $quantiteAchat = $commandeArticleRepository->venteInterne($article);
              $quantiteCredit = $creditArticleRepository->quantite($article);
              $quantiteDebit = $debitArticleRepository->quantite($article);
              $quantite = $quantiteCredit - ($quantiteAchatEncours + $quantiteAchat + $quantiteDebit); */
            if ($article->getQuantiteStock() < $article->getSeuilApprovisionnement()) {
                $nbreArticleReapprovisionnement++;
            }
        }
        return $nbreArticleReapprovisionnement;
    }

    private function achatArticle(ArticleRepository $articleRepository): int {
        $articles = $articleRepository->findBy(array('etat_val' => true, 'etat_del' => false));
        $achatArticle = 0;
        foreach ($articles as $article) {
            $achatArticle += $article->getPuAchat() * $article->getQuantiteCredit();
        }
        return $achatArticle;
    }

    /*
      private function commandeReglement(CommandeRepository $commandeRepository): array {

      $commandes = $commandeRepository->findBy(array('etat_val' => true, 'etat_del' => false));

      $nbreAttenteReglement = 0;
      $montantAttenteReglement = 0;
      $nbreReglement = 0;
      $montantReglement = 0;
      $montantVentes = 0;
      $montantLivraisons = 0;
      $montantAchats = 0;

      foreach ($commandes as $commande) {

      if ($commande->getEtatReception() == true && $commande->getUserMontant() == null) {
      $nbreAttenteReglement++;
      $montantAttenteReglement = $commande->getTotal();
      $montantVentes += $commande->getTotalCommandeArticle();
      $montantAchats += $commande->getAchatCommandeArticle();
      $montantLivraisons += $commande->getFraisLivraison();
      }

      if ($commande->getEtatReception() == true && $commande->getUserMontant() != null) {
      $nbreReglement++;
      $montantReglement = $commande->getTotal();
      $montantVentes += $commande->getTotalCommandeArticle();
      $montantAchats += $commande->getAchatCommandeArticle();
      $montantLivraisons += $commande->getFraisLivraison();
      }
      }

      return array("nbreAttenteReglement" => $nbreAttenteReglement, "montantAttenteReglement" => $montantAttenteReglement, "nbreReglement" => $nbreReglement, "montantReglement" => $montantReglement, "montantVentes" => $montantVentes, "montantLivraisons" => $montantLivraisons, "montantAchats" => $montantAchats);
      }
     */
}
