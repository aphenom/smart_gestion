<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\CreditArticle;
use App\Entity\DebitArticle;
use App\Form\ArticleType;
use App\Form\CreditArticleType;
use App\Form\DebitArticleType;
use App\Form\DebitArticleDefectueuxType;
use App\Repository\ArticleRepository;
use App\Repository\DebitArticleRepository;
use App\Repository\CommandeArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Controller\DefaultController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;


/**
 * @Security("is_granted('ROLE_LOG')")
 * @Route("/article")
 */
class ArticleController extends AbstractController {

    /**
     * @Route("/", name="article_index", methods={"GET"})
     */
    public function index(ArticleRepository $articleRepository): Response {
        if ($this->getUser()->getEntreprise()) {
            $articles = $articleRepository->findBy(array('etat_proprio' => true, "entreprise" => $this->getUser()->getEntreprise()), array('id' => 'Desc'));
        } else {
            $articles = $articleRepository->findBy(array('etat_proprio' => true), array('id' => 'Desc'));
        }
        return $this->render('article/index.html.twig', [
                    'articles' => $articles,
        ]);
    }

    /**
     * @Route("/new", name="article_new", methods={"GET","POST"})
     */
    public function new(Request $request, ArticleRepository $articleRepository, DefaultController $defaultController): Response {
        $article = new Article();
        if ($this->getUser()->getEntreprise()) {
            $article->setEntreprise($this->getUser()->getEntreprise());
        }
        $article->setUserAdd($this->getUser());
        $article->setUserVal($this->getUser());
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $date = new \Datetime();
            do {
                $sku = $defaultController->random_number(8); //$date->format('y').$date->format('m').$date->format('d').$defaultController->random_number(8);
                $existant = $articleRepository->findOneBySku($sku);
            } while ($existant);
            $article->setSku($sku);
            $article->setDateAdd($date);
            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('article_credit', array('id' => $article->getId()));
        }

        return $this->render('article/new.html.twig', [
                    'article' => $article,
                    'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/defectueux", name="article_defectueux", methods={"GET","POST"})
     */
    public function defectueux(Request $request): Response {
        $debitArticle = new DebitArticle();
        //$debitArticle->setArticle($article);
        if ($this->getUser()->getEntreprise()) {
            $debitArticle->setEntreprise($this->getUser()->getEntreprise());
        }
        $debitArticle->setUserAdd($this->getUser());
        $form = $this->createForm(DebitArticleDefectueuxType::class, $debitArticle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $debitArticle->setDateAdd(new \Datetime());
            $debitArticle->setEtatDefectueux(true);
            $debitArticle->setQuantite(1);
            $entityManager->persist($debitArticle);
            $entityManager->flush();

            return $this->redirectToRoute('article_index');
        }

        return $this->render('article/defectueux.html.twig', [
                    'debitArticle' => $debitArticle,
                    'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="article_show", methods={"GET"})
     */
    public function show(Article $article, DebitArticleRepository $debitArticleRepository, CommandeArticleRepository $commandeArticleRepository): Response {
        if ($this->getUser()->getEntreprise() && $this->getUser()->getEntreprise() != $article->getEntreprise()) {
            throw new AccessDeniedException('Accès limité.');
        }
        return $this->render('article/show.html.twig', [
                    'article' => $article,
                    'retraits' => $debitArticleRepository->findBy(array('article' => $article, 'etat_defectueux' => false), array('id' => 'Desc')),
                    'commandeArticles' => $commandeArticleRepository->findBy(array('article' => $article, 'etat_val' => true, 'etat_del' => false))
        ]);
    }

    /**
     * @Route("/{id}/edit", name="article_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Article $article): Response {

        if ($this->getUser()->getEntreprise() && $this->getUser()->getEntreprise() != $article->getEntreprise()) {
            throw new AccessDeniedException('Accès limité.');
        }

        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('article_show', array('id' => $article->getId()));
        }

        return $this->render('article/edit.html.twig', [
                    'article' => $article,
                    'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/credit", name="article_credit", methods={"GET","POST"})
     */
    public function credit(Request $request, Article $article): Response {
        if ($this->getUser()->getEntreprise() && $this->getUser()->getEntreprise() != $article->getEntreprise()) {
            throw new AccessDeniedException('Accès limité.');
        }
        $creditArticle = new CreditArticle();
        if ($this->getUser()->getEntreprise()) {
            $creditArticle->setEntreprise($this->getUser()->getEntreprise());
        }
        $creditArticle->setArticle($article);
        $creditArticle->setUserAdd($this->getUser());
        if (count($article->getCreditArticles()) < 1) {
            $creditArticle->setObjet("Quantité initiale");
        }
        $form = $this->createForm(CreditArticleType::class, $creditArticle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            if (count($article->getCreditArticles()) < 1) {
                $creditArticle->setObjet("Quantité initiale");
            }
            $creditArticle->setDateAdd(new \Datetime());
            $entityManager->persist($creditArticle);
            $entityManager->flush();

            return $this->redirectToRoute('article_show', array('id' => $article->getId()));
        }

        return $this->render('article/credit.html.twig', [
                    'creditArticle' => $creditArticle,
                    'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/debit", name="article_debit", methods={"GET","POST"})
     */
    public function debit(Request $request, Article $article): Response {
        if ($this->getUser()->getEntreprise() && $this->getUser()->getEntreprise() != $article->getEntreprise()) {
            throw new AccessDeniedException('Accès limité.');
        }
        $debitArticle = new DebitArticle();
        if ($this->getUser()->getEntreprise()) {
            $debitArticle->setEntreprise($this->getUser()->getEntreprise());
        }
        $debitArticle->setArticle($article);
        $debitArticle->setUserAdd($this->getUser());
        $form = $this->createForm(DebitArticleType::class, $debitArticle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $debitArticle->setDateAdd(new \Datetime());
            $entityManager->persist($debitArticle);
            $entityManager->flush();

            return $this->redirectToRoute('article_show', array('id' => $article->getId()));
        }

        return $this->render('article/debit.html.twig', [
                    'debitArticle' => $debitArticle,
                    'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="article_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Article $article): Response {
        if ($this->getUser()->getEntreprise() && $this->getUser()->getEntreprise() != $article->getEntreprise()) {
            throw new AccessDeniedException('Accès limité.');
        }
        if ($this->isCsrfTokenValid('delete' . $article->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($article);
            $entityManager->flush();
        }

        return $this->redirectToRoute('article_index');
    }

    /**
     * @Route("/{id}/desactivate", name="article_desactivate", methods={"GET","POST"})
     */
    public function desactivate(Request $request, Article $article): Response {
        if ($this->getUser()->getEntreprise() && $this->getUser()->getEntreprise() != $article->getEntreprise()) {
            throw new AccessDeniedException('Accès limité.');
        }
        if ($this->isCsrfTokenValid('desactivate' . $article->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $article->setEtatVal(false);
            $article->setUserVal($this->getUser());
            $entityManager->persist($article);
            $entityManager->flush();
        }

        return $this->redirectToRoute('article_index');
    }

    /**
     * @Route("/{id}/activate", name="article_activate", methods={"GET","POST"})
     */
    public function activate(Request $request, Article $article): Response {
        if ($this->getUser()->getEntreprise() && $this->getUser()->getEntreprise() != $article->getEntreprise()) {
            throw new AccessDeniedException('Accès limité.');
        }
        if ($this->isCsrfTokenValid('activate' . $article->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $article->setEtatVal(true);
            $article->setUserVal($this->getUser());
            $entityManager->persist($article);
            $entityManager->flush();
        }

        return $this->redirectToRoute('article_index');
    }

}
