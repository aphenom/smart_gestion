<?php

namespace App\Controller;

use App\Entity\Agent;
use App\Entity\User;
use App\Form\AgentType;
use App\Repository\AgentRepository;
use App\Repository\CommandeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Security("is_granted('ROLE_LIV')")
 * @Route("/agent")
 */
class AgentController extends AbstractController {

    /**
     * @Route("/", name="agent_index", methods={"GET"})
     */
    public function index(AgentRepository $agentRepository): Response {
        if ($this->getUser()->getEntreprise()) {
            $agents = $agentRepository->findBy(array("entreprise" => $this->getUser()->getEntreprise()), array('id' => 'Desc'));
        } else {
            $agents = $agentRepository->findBy(array(), array('id' => 'Desc'));
        }
        return $this->render('agent/index.html.twig', [
                    'agents' => $agents,
        ]);
    }

    /**
     * @Route("/new", name="agent_new", methods={"GET","POST"})
     */
    public function new(Request $request, UserPasswordEncoderInterface $encoder): Response {
        $agent = new Agent();
        //$user = new User();
        if ($this->getUser()->getEntreprise()) {
            $agent->setEntreprise($this->getUser()->getEntreprise());
        }
        $agent->setUserAdd($this->getUser());
        $form = $this->createForm(AgentType::class, $agent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $date_now = new \Datetime();

            $agent->setDateAdd($date_now);

            $user = new User();
            $role = array('ROLE_AGENT');
            $user->setUsername($agent->getUser()->getUsername());
            $user->setRoles($role);
            $user->setDateAdd($date_now);
            $user->setContact($agent->getContact());
            $user->setEntreprise($agent->getEntreprise());
            $user->setNom($agent->getNom());
            $user->setPrenom($agent->getPrenom());
            $user->setTextPassword($agent->getUser()->getPassword());
            $encoded = $encoder->encodePassword($user, $user->getTextPassword());
            $user->setPassword($encoded);

            $entityManager->persist($user);
            $agent->setUser($user);
            $entityManager->persist($agent);
            $entityManager->flush();

            return $this->redirectToRoute('agent_index');
        }

        return $this->render('agent/new.html.twig', [
                    'agent' => $agent,
                    'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="agent_show", methods={"GET","POST"})
     */
    public function show(Request $request, Agent $agent, CommandeRepository $commandeRepository): Response {
        if ($this->getUser()->getEntreprise() && $this->getUser()->getEntreprise() != $agent->getEntreprise()) {
            throw new AccessDeniedException('Accès limité.');
        }

        $date_debut = $request->request->get('date_debut');
        $date_fin = $request->request->get('date_fin');

        return $this->render('agent/show.html.twig', [
                    'agent' => $agent,
                    'commandes' => $commandeRepository->findBy(array('agent_livreur' => $agent, 'etat_livraison' => true)),
                    'date_debut' => $date_debut,
                    'date_fin' => $date_fin,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="agent_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Agent $agent, UserPasswordEncoderInterface $encoder): Response {

        if ($this->getUser()->getEntreprise() && $this->getUser()->getEntreprise() != $agent->getEntreprise()) {
            throw new AccessDeniedException('Accès limité.');
        }

        $form = $this->createForm(AgentType::class, $agent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user = $agent->getUser();
            $user->setContact($agent->getContact());
            $user->setEntreprise($agent->getEntreprise());
            $user->setNom($agent->getNom());
            $user->setPrenom($agent->getPrenom());

            $encodedLast = $encoder->encodePassword($user, $user->getTextPassword());
            $encoded = $encoder->encodePassword($user, $user->getPassword());
            if ($encodedLast != $encoded && $encodedLast != $user->getPassword()) {
                $user->setTextPassword($user->getPassword());
                $user->setPassword($encoded);
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('agent_index');
        }

        return $this->render('agent/edit.html.twig', [
                    'agent' => $agent,
                    'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="agent_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Agent $agent): Response {
        if ($this->getUser()->getEntreprise() && $this->getUser()->getEntreprise() != $agent->getEntreprise()) {
            throw new AccessDeniedException('Accès limité.');
        }
        if ($this->isCsrfTokenValid('delete' . $agent->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($agent);
            $entityManager->flush();
        }

        return $this->redirectToRoute('agent_index');
    }

    /**
     * @Route("/{id}/desactivate", name="agent_desactivate", methods={"GET","POST"})
     */
    public function desactivate(Request $request, Agent $agent): Response {
        if ($this->getUser()->getEntreprise() && $this->getUser()->getEntreprise() != $agent->getEntreprise()) {
            throw new AccessDeniedException('Accès limité.');
        }
        if ($this->isCsrfTokenValid('desactivate' . $agent->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $agent->setEtatVal(false);
            $agent->getUser()->setEtatVal(false);
            $entityManager->persist($agent);
            $entityManager->flush();
        }

        return $this->redirectToRoute('agent_index');
    }

    /**
     * @Route("/{id}/activate", name="agent_activate", methods={"GET","POST"})
     */
    public function activate(Request $request, Agent $agent): Response {
        if ($this->getUser()->getEntreprise() && $this->getUser()->getEntreprise() != $agent->getEntreprise()) {
            throw new AccessDeniedException('Accès limité.');
        }
        if ($this->isCsrfTokenValid('activate' . $agent->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $agent->setEtatVal(true);
            $agent->getUser()->setEtatVal(true);
            $entityManager->persist($agent);
            $entityManager->flush();
        }

        return $this->redirectToRoute('agent_index');
    }

}
