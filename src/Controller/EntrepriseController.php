<?php

namespace App\Controller;

use App\Entity\Entreprise;
use App\Form\EntrepriseType;
use App\Repository\EntrepriseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * @Route("/entreprise")
 */
class EntrepriseController extends AbstractController {

    /**
     * @Route("/", name="entreprise_index", methods={"GET"})
     */
    public function index(EntrepriseRepository $entrepriseRepository): Response {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN') || $this->getUser()->getEntreprise()) {
            // Sinon on déclenche une exception « Accès interdit »
            throw new AccessDeniedException('Accès limité.');
        }
        return $this->render('entreprise/index.html.twig', [
                    'entreprises' => $entrepriseRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="entreprise_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN') || $this->getUser()->getEntreprise()) {
            // Sinon on déclenche une exception « Accès interdit »
            throw new AccessDeniedException('Accès limité.');
        }
        $entreprise = new Entreprise();
        $form = $this->createForm(EntrepriseType::class, $entreprise);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entreprise->setDateAdd(new \DateTime());
            $entityManager->persist($entreprise);
            $entityManager->flush();

            return $this->redirectToRoute('entreprise_index');
        }

        return $this->render('entreprise/new.html.twig', [
                    'entreprise' => $entreprise,
                    'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="entreprise_show", methods={"GET"})
     */
    public function show(Entreprise $entreprise): Response {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN') || ($this->getUser()->getEntreprise() && $this->getUser()->getEntreprise() != $entreprise)) {
            // Sinon on déclenche une exception « Accès interdit »
            throw new AccessDeniedException('Accès limité.');
        }
        return $this->render('entreprise/show.html.twig', [
                    'entreprise' => $entreprise,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="entreprise_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Entreprise $entreprise): Response {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN') || ($this->getUser()->getEntreprise() && $this->getUser()->getEntreprise() != $entreprise)) {
            // Sinon on déclenche une exception « Accès interdit »
            throw new AccessDeniedException('Accès limité.');
        }
        $form = $this->createForm(EntrepriseType::class, $entreprise);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('entreprise_show', array('id' => $entreprise->getId()));
        }

        return $this->render('entreprise/edit.html.twig', [
                    'entreprise' => $entreprise,
                    'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="entreprise_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Entreprise $entreprise): Response {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN') || $this->getUser()->getEntreprise()) {
            // Sinon on déclenche une exception « Accès interdit »
            throw new AccessDeniedException('Accès limité.');
        }
        if ($this->isCsrfTokenValid('delete' . $entreprise->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($entreprise);
            $entityManager->flush();
        }

        return $this->redirectToRoute('entreprise_index');
    }

    /**
     * @Route("/{id}/desactivate", name="entreprise_desactivate", methods={"GET","POST"})
     */
    public function desactivate(Request $request, Entreprise $entreprise): Response {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN') || $this->getUser()->getEntreprise()) {
            // Sinon on déclenche une exception « Accès interdit »
            throw new AccessDeniedException('Accès limité.');
        }

        if ($this->isCsrfTokenValid('desactivate' . $entreprise->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entreprise->setEtatVal(false);
            $entreprise->setEtatDel(true);
            $entreprise->setDateDel(new \DateTime());
            $entityManager->persist($entreprise);
            $entityManager->flush();
        }

        return $this->redirectToRoute('entreprise_index');
    }

    /**
     * @Route("/{id}/activate", name="entreprise_activate", methods={"GET","POST"})
     */
    public function activate(Request $request, Entreprise $entreprise): Response {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN') || $this->getUser()->getEntreprise()) {
            // Sinon on déclenche une exception « Accès interdit »
            throw new AccessDeniedException('Accès limité.');
        }

        if ($this->isCsrfTokenValid('activate' . $entreprise->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entreprise->setEtatVal(true);
            $entreprise->setEtatDel(false);
            $entityManager->persist($entreprise);
            $entityManager->flush();
        }

        return $this->redirectToRoute('entreprise_index');
    }

}
