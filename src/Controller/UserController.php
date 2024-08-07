<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * @Route("/user")
 */
class UserController extends AbstractController {

    /**
     * @Route("/", name="user_index", methods={"GET"})
     */
    public function index(UserRepository $userRepository): Response {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            // Sinon on déclenche une exception « Accès interdit »
            throw new AccessDeniedException('Accès limité.');
        }

        if ($this->getUser()->getEntreprise()) {
            $users = $userRepository->myFindAll($this->getUser()->getEntreprise());
        } else {
            $users = $userRepository->myFindAll(null);
        }

        return $this->render('user/index.html.twig', [
                    'users' => $users,
        ]);
    }

    /**
     * @Route("/new", name="user_new", methods={"GET","POST"})
     */
    public function new(Request $request, UserPasswordEncoderInterface $encoder): Response {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            // Sinon on déclenche une exception « Accès interdit »
            throw new AccessDeniedException('Accès limité.');
        }

        $user = new User();
        //$role = array('ROLE_ADMIN');
        //$user->setRoles($role);
        if ($this->getUser()->getEntreprise()) {
            $user->setEntreprise($this->getUser()->getEntreprise());
        }

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $user->setDateAdd(new \Datetime());
            $user->setTextPassword($user->getPassword());
            $encoded = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($encoded);
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/new.html.twig', [
                    'user' => $user,
                    'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_show", methods={"GET","POST"})
     */
    public function show(Request $request, User $user): Response {
        if ($this->getUser() != $user) {
            $this->denyAccessUnlessGranted('ROLE_ADMIN');
        }

        if ($this->getUser()->getEntreprise() && $this->getUser()->getEntreprise() != $user->getEntreprise()) {
            throw new AccessDeniedException('Accès limité.');
        }


        $date_debut = $request->request->get('date_debut');
        $date_fin = $request->request->get('date_fin');

//        $debut = new \DateTime($date_debut);
//        var_dump($date_fin);
//        exit;

        return $this->render('user/show.html.twig', [
                    'user' => $user,
                    'date_debut' => $date_debut,
                    'date_fin' => $date_fin,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="user_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, User $user, UserPasswordEncoderInterface $encoder): Response {
        // $demandeur = $this->getUser();
        if ($this->getUser() != $user || $this->get('security.authorization_checker')->isGranted('ROLE_AGENT')) {
            $this->denyAccessUnlessGranted('ROLE_ADMIN');
        }

        if ($this->getUser()->getEntreprise() && $this->getUser()->getEntreprise() != $user->getEntreprise()) {
            throw new AccessDeniedException('Accès limité.');
        }

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $encodedLast = $encoder->encodePassword($user, $user->getTextPassword());
            $encoded = $encoder->encodePassword($user, $user->getPassword());
            if ($encodedLast != $encoded && $encodedLast != $user->getPassword()) {
                $user->setTextPassword($user->getPassword());
                $user->setPassword($encoded);
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_show', ['id' => $user->getId()]);
        }

        return $this->render('user/edit.html.twig', [
                    'user' => $user,
                    'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_delete", methods={"DELETE"})
     */
    public function delete(Request $request, User $user): Response {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_BIZARRE')) {
            // Sinon on déclenche une exception « Accès interdit »
            throw new AccessDeniedException('Accès limité.');
        }
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_index');
    }

    /**
     * @Route("/{id}/desactivate", name="user_desactivate", methods={"GET","POST"})
     */
    public function desactivate(Request $request, User $user): Response {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN') || $this->getUser()->getEntreprise() != $user->getEntreprise()) {
            // Sinon on déclenche une exception « Accès interdit »
            throw new AccessDeniedException('Accès limité.');
        }
        if ($this->isCsrfTokenValid('desactivate' . $user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $user->setEtatVal(false);
            $entityManager->persist($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_index');
    }

    /**
     * @Route("/{id}/activate", name="user_activate", methods={"GET","POST"})
     */
    public function activate(Request $request, User $user): Response {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN') || $this->getUser()->getEntreprise() != $user->getEntreprise()) {
            // Sinon on déclenche une exception « Accès interdit »
            throw new AccessDeniedException('Accès limité.');
        }
        if ($this->isCsrfTokenValid('activate' . $user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $user->setEtatVal(true);
            $entityManager->persist($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_index');
    }

}
