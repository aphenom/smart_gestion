<?php

namespace App\Controller;

use App\Controller\DefaultController;
use App\Entity\Commande;
use App\Entity\CommandeArticle;
use App\Entity\Historique;
use App\Entity\MessageExterne;
use App\Form\CommandeArticleType;
use App\Form\CommandeArticleExterneType;
use App\Form\CommandeType;
use App\Form\StepsType;
use App\Repository\CommandeRepository;
use App\Repository\ArticleRepository;
use App\Repository\CommandeArticleRepository;
use App\Repository\HistoriqueRepository;
use App\Repository\AgentRepository;
use App\Repository\UserRepository;
use App\Repository\EntrepriseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Options;
use Dompdf\Dompdf;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * @Route("/commande")
 */
class CommandeController extends AbstractController {

    /**
     * @Route("/", name="commande_index", methods={"GET"})
     */
    public function index(CommandeRepository $commandeRepository): Response {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_BIZARRE') || ($this->getUser()->getEntreprise() && $this->getUser()->getEntreprise() != $commande->getEntreprise())) {
            // Sinon on déclenche une exception « Accès interdit »
            throw new AccessDeniedException('Accès limité.');
        }
        if ($this->getUser()->getEntreprise()) {
            $commandes = $commandeRepository->findBy(array("entreprise" => $this->getUser()->getEntreprise()), array('id' => 'Desc'));
        } else {
            $commandes = $commandeRepository->findBy(array(), array('id' => 'Desc'));
        }
        return $this->render('commande/index.html.twig', [
                    'commandes' => $commandes,
        ]);
    }

    /**
     * @Route("/new/{role}", name="commande_new", methods={"GET","POST"})
     */
    public function new(string $role, Request $request, HttpClientInterface $client): Response {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_COM') && !$this->get('security.authorization_checker')->isGranted('ROLE_LIV')) {
            // Sinon on déclenche une exception « Accès interdit »
            throw new AccessDeniedException('Accès limité.');
        }

        $commande = new Commande();
        if ($this->getUser()->getEntreprise()) {
            $commande->setEntreprise($this->getUser()->getEntreprise());
        }

        if ($role == "livraison") {
            $commande->setEtatProprio(false);
            $commande->setEtatVal(true);
            $commande->setEtatLancement(true);
            $commande->setTypeCommande("service livraison");
        }

        $commande->setUserAdd($this->getUser());
        $form = $this->createForm(CommandeType::class, $commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $date = new \Datetime();
            $commande->setSku($date->getTimestamp());
            $commande->setDateAdd($date);
            $entityManager->persist($commande);

            $historique = new Historique();
            $historique->setCommande($commande);
            $historique->setCommentaire($commande->getCommentaire());
            $historique->setDate($date);
            $historique->setEtat("enregistrement");
            $historique->setEntreprise($this->getUser()->getEntreprise());
            $historique->setUser($this->getUser());
            $entityManager->persist($historique);

            if ($role == "livraison") {
                $message = ($commande->getEntreprise()->getMessage1() != "") ? $commande->getEntreprise()->getMessage1() : "";
                $type_message = 1;
                $this->envoiSMS($commande, $message, $historique, $type_message, $client);
                $entityManager->flush();
                return $this->redirectToRoute('commande_steps', array('id' => $commande->getId(), 'role' => $role, 'etat' => "all"));
            } else {
                $entityManager->flush();
                return $this->redirectToRoute('commande_article_new', array('id' => $commande->getId()));
            }
        }

        return $this->render('commande/new.html.twig', [
                    'commande' => $commande,
                    'form' => $form->createView(),
                    'role' => $role,
        ]);
    }

    /**
     * @Route("/{id}", name="commande_show", methods={"GET"})
     */
    public function show(Commande $commande): Response {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_BIZARRE') || ($this->getUser()->getEntreprise() && $this->getUser()->getEntreprise() != $commande->getEntreprise())) {
            // Sinon on déclenche une exception « Accès interdit »
            throw new AccessDeniedException('Accès limité.');
        }


        return $this->render('commande/show.html.twig', [
                    'commande' => $commande,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="commande_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Commande $commande, HistoriqueRepository $historiqueRepository): Response {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_COM') || ($this->getUser()->getEntreprise() && $this->getUser()->getEntreprise() != $commande->getEntreprise()) || (!$this->get('security.authorization_checker')->isGranted('ROLE_LIV') && $commande->getEtatProprio() == false)) {
            // Sinon on déclenche une exception « Accès interdit »
            throw new AccessDeniedException('Accès limité.');
        }

        $form = $this->createForm(CommandeType::class, $commande);
        $form->handleRequest($request);

        if (($form->isSubmitted() && $form->isValid()) && ($commande->getEtatLancement() == false && $commande->getEtatProprio() == true || ($commande->getEtatLivraison() == false && $commande->getEtatProprio() == false))) {

            $historique = $historiqueRepository->findOneBy(array("etat" => "enregistrement", "commande" => $commande), array("id" => "ASC"));
            if ($historique) {
                $historique->setCommentaire($commande->getCommentaire());
                $this->getDoctrine()->getManager()->persist($historique);
            }

            $this->getDoctrine()->getManager()->flush();

            if ($commande->getEtatProprio() == false) {
                return $this->redirectToRoute('commande_steps', array('id' => $commande->getId(), 'role' => "livraison", 'etat' => "all"));
            } else {
                return $this->redirectToRoute('commande_article_new', array('id' => $commande->getId()));
            }
        }

        return $this->render('commande/edit.html.twig', [
                    'commande' => $commande,
                    'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/article", name="commande_article_new", methods={"GET","POST"})
     */
    public function article(Request $request, Commande $commande, CommandeArticleRepository $commandeArticleRepository): Response {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_COM') || ($this->getUser()->getEntreprise() && $this->getUser()->getEntreprise() != $commande->getEntreprise())) {
            // Sinon on déclenche une exception « Accès interdit »
            throw new AccessDeniedException('Accès limité.');
        }

        $commandeArticle = new CommandeArticle();
        if ($this->getUser()->getEntreprise()) {
            $commandeArticle->setEntreprise($this->getUser()->getEntreprise());
        }
        $commandeArticle->setCommande($commande);
        $form = $this->createForm(CommandeArticleType::class, $commandeArticle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() && $commande->getEtatLivraison() == false) {
            $entityManager = $this->getDoctrine()->getManager();
            $commandeArticle->setPuAchat($commandeArticle->getArticle()->getPuAchat());
            $commandeArticle->setPuVente($commandeArticle->getArticle()->getPuVente());
            $commandeArticle->setDateAdd(new \Datetime());
            $entityManager->persist($commandeArticle);
            $entityManager->flush();

            return $this->redirectToRoute('commande_article_new', array('id' => $commande->getId()));
        }

        return $this->render('commande/article_new.html.twig', [
                    'commandeArticle' => $commandeArticle,
                    'commandeArticles' => $commandeArticleRepository->findBy(array('commande' => $commande, 'etat_val' => true, 'etat_del' => false)),
                    'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/article_externe", name="commande_article_externe_new", methods={"GET","POST"})
     */
    public function articleExterne(Request $request, Commande $commande, CommandeArticleRepository $commandeArticleRepository, ArticleRepository $articleRepository, DefaultController $defaultController): Response {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_COM') || ($this->getUser()->getEntreprise() && $this->getUser()->getEntreprise() != $commande->getEntreprise())) {
            // Sinon on déclenche une exception « Accès interdit »
            throw new AccessDeniedException('Accès limité.');
        }

        $commandeArticle = new CommandeArticle();
        if ($this->getUser()->getEntreprise()) {
            $commandeArticle->setEntreprise($this->getUser()->getEntreprise());
        }
        $commandeArticle->setCommande($commande);
        $form = $this->createForm(CommandeArticleExterneType::class, $commandeArticle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() && $commande->getEtatLivraison() == false) {
            $entityManager = $this->getDoctrine()->getManager();
            $article = $commandeArticle->getArticle();
            if ($this->getUser()->getEntreprise()) {
                $article->setEntreprise($this->getUser()->getEntreprise());
            }
            $article->setEtatProprio(false);
            $article->setUserAdd($this->getUser());
            $article->setUserVal($this->getUser());
            do {
                $sku = $defaultController->random_number(8);
                $existant = $articleRepository->findOneBySku($sku);
            } while ($existant);
            $article->setSku($sku);
            $article->setDateAdd(new \Datetime());
            $entityManager->persist($article);
            $commandeArticle->setPuAchat($article->getPuAchat());
            $commandeArticle->setPuVente($article->getPuVente());
            $commandeArticle->setDateAdd(new \Datetime());
            $entityManager->persist($commandeArticle);
            $entityManager->flush();

            return $this->redirectToRoute('commande_article_externe_new', array('id' => $commande->getId()));
        }

        return $this->render('commande/article_externe_new.html.twig', [
                    'commandeArticle' => $commandeArticle,
                    'commandeArticles' => $commandeArticleRepository->findBy(array('commande' => $commande, 'etat_val' => true, 'etat_del' => false)),
                    'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/facture", name="commande_facture", methods={"GET","POST"})
     */
    public function facture(Commande $commande, CommandeArticleRepository $commandeArticleRepository) {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_LOG') || ($this->getUser()->getEntreprise() && $this->getUser()->getEntreprise() != $commande->getEntreprise()) || (!$this->get('security.authorization_checker')->isGranted('ROLE_LIV') && $commande->getEtatProprio() == false)) {
            // Sinon on déclenche une exception « Accès interdit »
            throw new AccessDeniedException('Accès limité.');
        }

//// On récupère l'objet à afficher (rien d'inconnu jusque là)
//    $objectsRepository = $this->getDoctrine()->getRepository('TestBundle:Object');
//    $object = $objectsRepository->findOneById($objectId);        
        // On crée une  instance pour définir les options de notre fichier pdf
        $options = new Options();
        // Pour simplifier l'affichage des images, on autorise dompdf à utiliser 
        // des  url pour les nom de  fichier
        $options->set('isRemoteEnabled', TRUE);
        // On crée une instance de dompdf avec  les options définies
        $dompdf = new Dompdf($options);
        // On demande à Symfony de générer  le code html  correspondant à 
        // notre template, et on stocke ce code dans une variable
        $html = $this->renderView('commande/facture_pdf.html.twig', array(
            'commande' => $commande,
            'commandeArticles' => $commandeArticleRepository->findBy(array('commande' => $commande, 'etat_val' => true, 'etat_del' => false)),)
        );
        // On envoie le code html  à notre instance de dompdf
        $dompdf->loadHtml($html);
        // On demande à dompdf de générer le  pdf
        $dompdf->render();
        // On renvoie  le flux du fichier pdf dans une  Response pour l'utilisateur
        return new Response($dompdf->stream('Facture-' . $commande->getSku() . '.pdf', array("Attachment" => false)));
    }

    /**
     * @Route("/{id}", name="commande_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Commande $commande): Response {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_BIZARRE') || ($this->getUser()->getEntreprise() && $this->getUser()->getEntreprise() != $commande->getEntreprise())) {
            // Sinon on déclenche une exception « Accès interdit »
            throw new AccessDeniedException('Accès limité.');
        }

        if ($this->isCsrfTokenValid('delete' . $commande->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($commande);
            $entityManager->flush();
        }

        return $this->redirectToRoute('commande_index');
    }

    /**
     * @Route("/{id}/desactivate_article", name="commande_article_delete", methods={"GET","POST"})
     */
    public function desactivateArticle(Request $request, CommandeArticle $commandeArticle): Response {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_COM') || ($this->getUser()->getEntreprise() && $this->getUser()->getEntreprise() != $commandeArticle->getEntreprise())) {
            // Sinon on déclenche une exception « Accès interdit »
            throw new AccessDeniedException('Accès limité.');
        }

        if ($this->isCsrfTokenValid('desactivate' . $commandeArticle->getId(), $request->request->get('_token')) && $commandeArticle->getCommande()->getEtatLivraison() == false) {
            $entityManager = $this->getDoctrine()->getManager();
            $commandeArticle->setEtatVal(false);
            $commandeArticle->setEtatDel(true);
            $commandeArticle->setDateDel(new \DateTime());
            $entityManager->persist($commandeArticle);
            $entityManager->flush();
        }

        return $this->redirect($_SERVER['HTTP_REFERER']);
    }

    /**
     * @Route("/{id}/desactivate", name="commande_desactivate", methods={"GET","POST"})
     */
    public function desactivate(Request $request, Commande $commande): Response {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_COM') || ($this->getUser()->getEntreprise() && $this->getUser()->getEntreprise() != $commande->getEntreprise())) {
            // Sinon on déclenche une exception « Accès interdit »
            throw new AccessDeniedException('Accès limité.');
        }

        if ($this->isCsrfTokenValid('desactivate' . $commande->getId(), $request->request->get('_token')) && $commande->getEtatLivraison() == false) {

            $date = new \Datetime();

            $entityManager = $this->getDoctrine()->getManager();
            $commande->setEtatVal(false);
            $commande->setEtatDel(true);
            $commande->setEtatRelance(false);
            $commande->setDateDel($date);
            $entityManager->persist($commande);


            $historique = new Historique();
            $historique->setCommande($commande);
            $historique->setCommentaire($request->request->get('commentaire'));
            $historique->setDate($date);
            $historique->setEtat("etat_del");
            $historique->setEntreprise($this->getUser()->getEntreprise());
            $historique->setUser($this->getUser());
            $entityManager->persist($historique);

            $entityManager->flush();
        }

        return $this->redirectToRoute('commande_article_new', array('id' => $commande->getId()));
    }

    /**
     * @Route("/{id}/activate", name="commande_activate", methods={"GET","POST"})
     */
    public function activate(Request $request, Commande $commande, HttpClientInterface $client): Response {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_COM') || ($this->getUser()->getEntreprise() && $this->getUser()->getEntreprise() != $commande->getEntreprise())) {
            // Sinon on déclenche une exception « Accès interdit »
            throw new AccessDeniedException('Accès limité.');
        }

        if ($this->isCsrfTokenValid('activate' . $commande->getId(), $request->request->get('_token')) && $commande->getEtatLivraison() == false) {

            $date = new \Datetime();

            $entityManager = $this->getDoctrine()->getManager();
            $commande->setEtatVal(true);
            $commande->setEtatDel(false);
            $commande->setEtatRelance(false);
            $commande->setDateVal($date);
            $entityManager->persist($commande);

            $historique = new Historique();
            $historique->setCommande($commande);
            $historique->setCommentaire($request->request->get('commentaire'));
            $historique->setDate($date);
            $historique->setEtat("etat_val");
            $historique->setEntreprise($this->getUser()->getEntreprise());
            $historique->setUser($this->getUser());
            $entityManager->persist($historique);

            $message = ($commande->getEntreprise()->getMessage1() != "") ? $commande->getEntreprise()->getMessage1() : "";
            $type_message = 1;
            $this->envoiSMS($commande, $message, $historique, $type_message, $client);

            $entityManager->flush();
        }

        return $this->redirectToRoute('commande_article_new', array('id' => $commande->getId()));
    }

    /**
     * @Route("/{id}/relance_commande", name="commande_relance", methods={"GET","POST"})
     */
    public function relance(Request $request, Commande $commande): Response {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_COM') || ($this->getUser()->getEntreprise() && $this->getUser()->getEntreprise() != $commande->getEntreprise())) {
            // Sinon on déclenche une exception « Accès interdit »
            throw new AccessDeniedException('Accès limité.');
        }

        if ($this->isCsrfTokenValid('relance' . $commande->getId(), $request->request->get('_token')) && $commande->getEtatLivraison() == false) {

            $date = new \Datetime();

            $entityManager = $this->getDoctrine()->getManager();
            $commande->setEtatVal(false);
            $commande->setEtatDel(false);
            $commande->setEtatRelance(true);
            $commande->setDateRelance($date);
            $entityManager->persist($commande);

            $historique = new Historique();
            $historique->setCommande($commande);
            $historique->setCommentaire($request->request->get('commentaire'));
            $historique->setDate($date);
            $historique->setEtat("etat_relance");
            $historique->setEntreprise($this->getUser()->getEntreprise());
            $historique->setUser($this->getUser());
            $entityManager->persist($historique);

            $entityManager->flush();
        }

        return $this->redirectToRoute('commande_article_new', array('id' => $commande->getId()));
    }

    /**
     * @Route("/{role}/{etat}", name="commande_global_index", methods={"GET"})
     */
    public function indexGlobal(string $role, string $etat, CommandeRepository $commandeRepository, AgentRepository $agentRepository): Response {

        $array_filtre = [];
        $array_tri = [];
        $titre = "";
        $acces = "";

        switch ($role) {
            case "commercial":
                $acces = "ROLE_COM";
                $array_filtre['etat_proprio'] = true;
                switch ($etat) {
                    case "all":
                        $array_tri["id"] = "Desc";
                        $titre .= "Commandes";
                        break;
                    case "valide":
                        $array_filtre['etat_val'] = true;
                        $array_tri["date_val"] = "Desc";
                        $titre .= "Commandes Validées";
                        break;
                    case "attente":
                        $array_filtre['etat_val'] = false;
                        $array_filtre['etat_relance'] = false;
                        $array_filtre['etat_del'] = false;
                        $array_tri["id"] = "Desc";
                        $titre .= "Commandes non valides";
                        break;
                    case "relance":
                        $array_filtre['etat_relance'] = true;
                        $array_tri["date_relance"] = "Asc";
                        $titre .= "Commandes à relancer";
                        break;
                    case "del":
                        $array_filtre['etat_del'] = true;
                        $array_tri["date_del"] = "Desc";
                        $titre .= "Commandes annulées";
                        break;
                }
                break;
            case "logistique":
                $acces = "ROLE_LOG";
                $array_filtre['etat_proprio'] = true;
                $array_filtre['etat_val'] = true;
                switch ($etat) {
                    case "all":
                        $array_tri["id"] = "Desc";
                        $titre .= "Commandes";
                        break;
                    case "valide":
                        $array_filtre['etat_lancement'] = true;
                        $array_tri["date_lancement"] = "Desc";
                        $titre .= "Commandes Validées";
                        break;
                    case "attente":
                        $array_filtre['etat_lancement'] = false;
                        $array_filtre['etat_relance'] = false;
                        $array_filtre['etat_del'] = false;
                        $array_tri["date_livraison_souhaite"] = "Asc";
                        $titre .= "Commandes en attente";
                        break;
                    case "relance":
                        $array_filtre['etat_relance'] = true;
                        $array_tri["date_relance"] = "Asc";
                        $titre .= "Commandes à relancer";
                        break;
                    case "del":
                        $array_filtre['etat_del'] = true;
                        $array_tri["date_del"] = "Asc";
                        $titre .= "Commandes annulées";
                        break;
                }
                break;

            case "livraison":
                $acces = "ROLE_LIV";
//                $array_filtre['etat_proprio'] = true;
                $array_filtre['etat_val'] = true;
                $array_filtre['etat_lancement'] = true;
                switch ($etat) {
                    case "all":
                        $array_tri["id"] = "Desc";
                        $titre .= "Commandes";
                        break;
                    case "valide":
                        $array_filtre['etat_livraison'] = true;
                        $array_filtre['etat_livraison_val'] = false;
                        $array_tri["date_livraison"] = "Desc";
                        $titre .= "Livraisons en cours";
                        break;
                    case "attente":
                        $array_filtre['etat_livraison'] = false;
                        $array_filtre['etat_relance'] = false;
                        $array_filtre['etat_del'] = false;
                        $array_tri["date_livraison_souhaite"] = "Asc";
                        $titre .= "Commandes en attente";
                        break;
                    case "agent-valide":
                        $array_filtre['etat_livraison'] = true;
                        $array_filtre['etat_livraison_agent'] = true;
                        $array_filtre['etat_livraison_val'] = true;
                        $array_tri["date_livraison_val"] = "Desc";
                        $titre .= "Livraisons validées";
                        break;
                    case "agent-attente":
                        $array_filtre['etat_livraison'] = true;
                        $array_filtre['etat_livraison_agent'] = true;
                        $array_filtre['etat_livraison_val'] = false;
                        $array_filtre['etat_relance'] = false;
                        $array_filtre['etat_del'] = false;
                        $array_tri["date_livraison_agent"] = "Asc";
                        $titre .= "Livraisons à valider";
                        break;
                    case "relance":
                        $array_filtre['etat_relance'] = true;
                        $array_tri["date_relance"] = "Asc";
                        $titre .= "Commandes à relancer";
                        break;
                    case "del":
                        $array_filtre['etat_del'] = true;
                        $array_tri["date_del"] = "Asc";
                        $titre .= "Commandes annulées";
                        break;
                }
                break;

            case "agent":
                $acces = "ROLE_AGENT";
//                $array_filtre['etat_proprio'] = true;
                $array_filtre['etat_val'] = true;
                $array_filtre['etat_lancement'] = true;
                $array_filtre['etat_livraison'] = true;
                $array_filtre['etat_livraison_val'] = false;
                if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
                    // Sinon on déclenche une exception « Accès interdit »
                    $array_filtre['agent_livreur'] = $agentRepository->findOneBy(array("user" => $this->getUser(), 'etat_val' => true, 'etat_del' => false));
                }
                switch ($etat) {
                    case "all":
                        $array_tri["id"] = "Desc";
                        $titre .= "Commandes";
                        break;
                    case "valide":
                        $array_filtre['etat_livraison_agent'] = true;
                        $array_tri["date_livraison_agent"] = "Desc";
                        $titre .= "Livraisons validées";
                        break;
                    case "attente":
                        $array_filtre['etat_livraison_agent'] = false;
                        $array_tri["date_livraison"] = "Asc";
                        $titre .= "Livraisons à valider";
                        break;
                }
                break;

            case "comptabilite":
                $acces = "ROLE_FIN";
//                $array_filtre['etat_proprio'] = true;
                $array_filtre['etat_val'] = true;
                $array_filtre['etat_lancement'] = true;
                $array_filtre['etat_livraison'] = true;
                $array_filtre['etat_livraison_agent'] = true;
                $array_filtre['etat_livraison_val'] = true;
                switch ($etat) {
                    case "all":
                        $array_tri["id"] = "Desc";
                        $titre .= "Commandes";
                        break;
                    case "valide":
                        $array_filtre['etat_comptabilite'] = true;
                        $array_tri["date_comptabilite"] = "Desc";
                        $titre .= "Commandes Validées";
                        break;
                    case "attente":
                        $array_filtre['etat_comptabilite'] = false;
                        $array_tri["date_livraison_val"] = "Asc";
                        $titre .= "Commandes à valider";
                        break;
                }
                break;
        }

        if (!$this->get('security.authorization_checker')->isGranted($acces)) {
            // Sinon on déclenche une exception « Accès interdit »
            throw new AccessDeniedException('Accès limité.');
        }
        if ($this->getUser()->getEntreprise()) {
            $array_filtre['entreprise'] = $this->getUser()->getEntreprise();
        }
        $commandes = $commandeRepository->findBy($array_filtre, $array_tri);

        return $this->render('commande/index.html.twig', [
                    'commandes' => $commandes,
                    'titre' => $titre,
                    'role' => $role,
                    'etat' => $etat,
        ]);
    }

    /**
     * @Route("/{id}/steps/{role}/{etat}", name="commande_steps", methods={"GET","POST"})
     */
    public function steps(string $role, string $etat, Request $request, Commande $commande, CommandeArticleRepository $commandeArticleRepository, HttpClientInterface $client): Response {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_LOG') && !$this->get('security.authorization_checker')->isGranted('ROLE_LIV') && !$this->get('security.authorization_checker')->isGranted('ROLE_AGENT') && !$this->get('security.authorization_checker')->isGranted('ROLE_FIN') && ($this->getUser()->getEntreprise() && $this->getUser()->getEntreprise() != $commande->getEntreprise())) {
            // Sinon on déclenche une exception « Accès interdit »
            throw new AccessDeniedException('Accès limité.');
        }

        $form = $this->createForm(StepsType::class, $commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $date = new \Datetime();

            $historique = new Historique();
            $historique->setCommande($commande);

            $message = "";
            $type_message = 0;

            switch ($commande->getTypeEtat()) {
                case "etat_lancement":
                    $commande->setDateLancement($date);
                    $message = ($commande->getEntreprise()->getMessage2() != "") ? $commande->getEntreprise()->getMessage2() : "";
                    $type_message = 2;
                    break;
                case "etat_livraison":
                    $commande->setDateLivraison($date);
                    $message = ($commande->getEntreprise()->getMessage3() != "") ? $commande->getEntreprise()->getMessage3() : "";
                    $type_message = 3;
                    break;
                case "etat_livraison_agent":
                    $commande->setDateLivraisonAgent($date);
                    $message = ($commande->getEntreprise()->getMessage4() != "") ? $commande->getEntreprise()->getMessage4() : "";
                    $type_message = 4;
                    if ($commande->getAgentLivreur()->getUser() != $this->getUser()) {
                        throw new AccessDeniedException('Accès limité.');
                    }
                    break;
                case "etat_livraison_val":
                    $commande->setDateLivraisonVal($date);
                    //$message = ($commande->getEntreprise()->getMessage5() != "") ? $commande->getEntreprise()->getMessage5() : "";
                    break;
                case "etat_comptabilite":
                    $commande->setDateComptabilite($date);
                    break;
                case "etat_relance":
                    $commande->setDateRelance($date);
                    if ($commande->getEtatLancement() == true && $commande->getEtatLivraison() == false) {
                        $message = ($commande->getEntreprise()->getMessage5() != "") ? $commande->getEntreprise()->getMessage5() : "";
                        $type_message = 5;
                    }
                    break;
                case "etat_delete":
                    $commande->setDateDel($date);
                    break;
            }

            $historique->setEtat($commande->getTypeEtat());
            $historique->setCommentaire($commande->getCommentaire());
            $historique->setDate($date);
            $historique->setEntreprise($this->getUser()->getEntreprise());
            $historique->setUser($this->getUser());

            $entityManager->persist($commande);

            $entityManager->persist($historique);

            $this->envoiSMS($commande, $message, $historique, $type_message, $client);

            $entityManager->flush();

            return $this->redirectToRoute('commande_steps', array('id' => $commande->getId(), 'role' => $role, 'etat' => $etat));
        }

        return $this->render('commande/steps.html.twig', [
                    'commande' => $commande,
                    'commandeArticles' => $commandeArticleRepository->findBy(array('commande' => $commande, 'etat_val' => true, 'etat_del' => false)),
                    'form' => $form->createView(),
                    'role' => $role,
                    'etat' => $etat,
        ]);
    }

    private function envoiSMS(Commande $commande, string $message, Historique $historique, int $type_message, HttpClientInterface $client) {
        if (strlen($commande->getNumeroClient()) > 7 && $commande->getEntreprise()->getApiMessage() != "" && $message != "") {

            $messageExterne = new MessageExterne();
            $messageExterne->setContacts($commande->getNumeroClient());
            $messageExterne->setEntreprise($commande->getEntreprise());
            $messageExterne->setHistorique($historique);
            $messageExterne->setTypeMessage($type_message);

            //$message = $messageExterne->getContenu();

            $indesirable = array(",", "+", "\r\n", "\n");
            $destinataires = str_replace($indesirable, ";", $messageExterne->getContacts());
            $destinataires = str_replace(array(" ", "+"), "", $destinataires);
            $message = str_replace("&", " ", $message);

            if ($commande->getAgentLivreur()) {
                $nom_agent_livreur = $commande->getAgentLivreur()->getNom();
                $contact_agent_livreur = $commande->getAgentLivreur()->getContact();
            } else {
                $nom_agent_livreur = '';
                $contact_agent_livreur = '';
            }

            $variables = array("{nom_client}", "{numero_commande}", "{montant_commande}", "{montant_livraison}", "{montant_total}", "{nom_livreur}", "{contact_livreur}", "{date_livraison}");
            $correspondances = array($commande->getNomClient(), $commande->getSku(), $commande->getTotalCommandeArticle(), $commande->getFraisLivraison(), $commande->getTotal(), $nom_agent_livreur, $contact_agent_livreur, $commande->getDateLivraisonSouhaite()->format("d-m-Y H:i"));

            $message = str_replace($variables, $correspondances, $message);

            $messageExterne->setContenu($message);

            //$message = str_replace("+", "%2b", $message);

            $response = $client->request(
                    'GET',
                    '' . $commande->getEntreprise()->getApiMessage() . '&text=' . $message . '&to=' . $destinataires . ''
            );

            $statusCode = $response->getStatusCode();
            // $statusCode = 200
            $contentType = $response->getHeaders()['content-type'][0];
            // $contentType = 'application/json'
            $content = $response->getContent();
            // $content = '{"id":521583, "name":"symfony-docs", ...}'
            // $content = $response->toArray();

            $parsed_json = json_decode($content);

            if ($parsed_json && $parsed_json->{'statut'} > 0) {

                $date = new \Datetime();

                $messageExterne->setDateAdd($date);
                //$messageExterne->setDateVal($date);

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($messageExterne);
            }

            // return true;
        }
    }
    
/*
    /**
     * @Route("/{role}/{etat}", name="commande_global_index", methods={"GET"})
     /
    public function envoiMailRelance(string $role, string $etat, CommandeRepository $commandeRepository, UserRepository $userRepository, EntrepriseRepository $entrepriseRepository): Response {

        $array_filtre = [];
        $array_tri = [];
        $titre = "";
        $acces = "";

        $entreprises = $entrepriseRepository->findBy(array("etat_val" => true, "etat_del" => false), array("id" => "ASC"));
        foreach ($entreprises as $entreprise) {
            $users = $userRepository->myFindAll($entreprise);
            $array_filtre['entreprise'] = $entreprise;
            foreach ($users as $user) {
                switch ($user->getRoles()) {
                    case (in_array("ROLE_COM", $user->getRoles())):
                        $acces = "ROLE_COM";
                        $array_filtre['etat_proprio'] = true;
                        $array_filtre['etat_relance'] = true;
                        $array_tri["date_relance"] = "Asc";
                        $titre .= "Commandes à relancer";
                        break;

                    case (in_array("ROLE_LOG", $user->getRoles())):
                        $acces = "ROLE_LOG";
                        $array_filtre['etat_proprio'] = true;
                        $array_filtre['etat_val'] = true;
                        $array_filtre['etat_relance'] = true;
                        $array_tri["date_relance"] = "Asc";
                        $titre .= "Commandes à relancer";
                        break;

                    case (in_array("ROLE_LIV", $user->getRoles())):
                        $acces = "ROLE_LIV";
//                $array_filtre['etat_proprio'] = true;
                        $array_filtre['etat_val'] = true;
                        $array_filtre['etat_lancement'] = true;
                        $array_filtre['etat_relance'] = true;
                        $array_tri["date_relance"] = "Asc";
                        $titre .= "Commandes à relancer";
                        break;
                }

                $commandes = $commandeRepository->findBy($array_filtre, $array_tri);
            }
        }

        return $this->render('commande/index.html.twig', [
                    'commandes' => $commandes,
                    'titre' => $titre,
                    'role' => $role,
                    'etat' => $etat,
        ]);
    }
*/
    
}
