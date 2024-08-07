<?php

namespace App\Controller;

use App\Entity\AutreTransaction;
use App\Form\AutreTransactionType;
use App\Repository\AutreTransactionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;


/**
 * @Security("is_granted('ROLE_FIN')")
 * @Route("/autre_transaction")
 */
class AutreTransactionController extends AbstractController {

    /**
     * @Route("/", name="autre_transaction_index", methods={"GET"})
     */
    public function index(AutreTransactionRepository $autreTransactionRepository): Response {
        if ($this->getUser()->getEntreprise()) {
            $autre_transactions = $autreTransactionRepository->findBy(array("entreprise" => $this->getUser()->getEntreprise(), 'etat_val' => true, 'etat_del' => false), array('id' => 'Desc'));
        } else {
            $autre_transactions = $autreTransactionRepository->findBy(array('etat_val' => true, 'etat_del' => false), array('id' => 'Desc'));
        }
        return $this->render('autre_transaction/index.html.twig', [
                    'autre_transactions' => $autre_transactions,
        ]);
    }

    /**
     * @Route("/new", name="autre_transaction_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response {
        $autreTransaction = new AutreTransaction();
        if ($this->getUser()->getEntreprise()) {
            $autreTransaction->setEntreprise($this->getUser()->getEntreprise());
        }
        $autreTransaction->setUserAdd($this->getUser());
        $form = $this->createForm(AutreTransactionType::class, $autreTransaction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $autreTransaction->setDateAdd(new \Datetime());
            $entityManager->persist($autreTransaction);
            $entityManager->flush();

            return $this->redirectToRoute('autre_transaction_index');
        }

        return $this->render('autre_transaction/new.html.twig', [
                    'autre_transaction' => $autreTransaction,
                    'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="autre_transaction_show", methods={"GET"})
     */
    public function show(AutreTransaction $autreTransaction): Response {
        if ($this->getUser()->getEntreprise() && $this->getUser()->getEntreprise() != $autreTransaction->getEntreprise()) {
            throw new AccessDeniedException('Accès limité.');
        }
        return $this->render('autre_transaction/show.html.twig', [
                    'autre_transaction' => $autreTransaction,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="autre_transaction_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, AutreTransaction $autreTransaction): Response {
        if ($this->getUser()->getEntreprise() && $this->getUser()->getEntreprise() != $autreTransaction->getEntreprise()) {
            throw new AccessDeniedException('Accès limité.');
        }
        $form = $this->createForm(AutreTransactionType::class, $autreTransaction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('autre_transaction_index');
        }

        return $this->render('autre_transaction/edit.html.twig', [
                    'autre_transaction' => $autreTransaction,
                    'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="autre_transaction_delete", methods={"DELETE"})
     */
    public function delete(Request $request, AutreTransaction $autreTransaction): Response {
        if ($this->getUser()->getEntreprise() && $this->getUser()->getEntreprise() != $autreTransaction->getEntreprise()) {
            throw new AccessDeniedException('Accès limité.');
        }
        if ($this->isCsrfTokenValid('delete' . $autreTransaction->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($autreTransaction);
            $entityManager->flush();
        }

        return $this->redirectToRoute('autre_transaction_index');
    }

    /**
     * @Route("/{id}/desactivate", name="autre_transaction_desactivate", methods={"GET","POST"})
     */
    public function desactivate(Request $request, AutreTransaction $autreTransaction): Response {
        if ($this->getUser()->getEntreprise() && $this->getUser()->getEntreprise() != $autreTransaction->getEntreprise()) {
            throw new AccessDeniedException('Accès limité.');
        }
        if ($this->isCsrfTokenValid('desactivate' . $article->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $autreTransaction->setEtatVal(false);
            $entityManager->persist($autreTransaction);
            $entityManager->flush();
        }

        return $this->redirectToRoute('autre_transaction_index');
    }

    /**
     * @Route("/{id}/activate", name="autre_transaction_activate", methods={"GET","POST"})
     */
    public function activate(Request $request, AutreTransaction $autreTransaction): Response {
        if ($this->getUser()->getEntreprise() && $this->getUser()->getEntreprise() != $autreTransaction->getEntreprise()) {
            throw new AccessDeniedException('Accès limité.');
        }
        if ($this->isCsrfTokenValid('activate' . $autreTransaction->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $autreTransaction->setEtatVal(true);
            $entityManager->persist($autreTransaction);
            $entityManager->flush();
        }

        return $this->redirectToRoute('autre_transaction_index');
    }

}
