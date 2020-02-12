<?php

namespace GroupeBundle\Controller;

use FOSBundle\Entity\User;
use GroupeBundle\Entity\Demande;
use GroupeBundle\Entity\Groupe;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

/**
 * Groupe controller.
 *
 */
class GroupeController extends Controller
{
    /**
     * Lists all groupe entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $groupes = $em->getRepository('GroupeBundle:Groupe')->findAll();

        return $this->render('groupe/show.html.twig', array(
            'groupes' => $groupes,
        ));
    }

    public function demandeAction(Request $request,$id)
    {
        $demande = new Demande();
        $demande->setUser($this->getUser()->getId());
        $groupe=new Groupe();
        $groupe= $this->getDoctrine()->getRepository(Groupe::class)->find($id);
        $demande->setGroupe($groupe);
        $em = $this->getDoctrine()->getManager();
        $em->persist($demande);
        $em->flush();
        return $this->redirectToRoute('groupe_list');
    }
    public function acceptAction($id_groupe,$id_user,$id)
    {     $groupe= $this->getDoctrine()->getRepository(Groupe::class)->find($id_groupe);
        //if($groupe->getUser()==$this->getUser())
        {
            $user = $this->getDoctrine()->getRepository(User::class)->find($id_user);
            $user->getGroupes()->add($groupe);
            $demande = $this->getDoctrine()->getRepository(Demande::class)->find($id);
            $em = $this->getDoctrine()->getManager();
            $em->remove($demande);
            $em->flush();
            $demandes = $em->getRepository('GroupeBundle:Demande')->findAll();

            return $this->render('groupe/list_invitation.html.twig', array(
                'demandes' => $demandes,
            ));
        }
    }
    public function demandesAction()
    {
        $em = $this->getDoctrine()->getManager();
        $demandes = $em->getRepository('GroupeBundle:Demande')->findAll();

        return $this->render('groupe/list_invitation.html.twig', array(
            'demandes' => $demandes,
        ));
    }

    public function groupsAction()
    {
        $em = $this->getDoctrine()->getManager();

        $groupes = $em->getRepository('GroupeBundle:Groupe')->findAll();

        return $this->render('groupe/show.html.twig', array(
            'groupes' => $groupes,
        ));
    }

    /**
     * Creates a new groupe entity.
     *
     */
    public function newAction(Request $request)
    {
        $groupe = new Groupe();
        $form = $this->createForm('GroupeBundle\Form\GroupeType', $groupe);
        $groupe->setUser($this->getUser());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($groupe);
            $em->flush();

            return $this->redirectToRoute('groupe_show', array('id' => $groupe->getId()));
        }

        return $this->render('groupe/new.html.twig', array(
            'groupe' => $groupe,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a groupe entity.
     *
     */
    public function showAction(Groupe $groupe)
    {
        $deleteForm = $this->createDeleteForm($groupe);

        return $this->render('groupe/show.html.twig', array(
            'groupe' => $groupe,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing groupe entity.
     *
     */
    public function editAction(Request $request, Groupe $groupe)
    {
        $deleteForm = $this->createDeleteForm($groupe);
        $editForm = $this->createForm('GroupeBundle\Form\GroupeType', $groupe);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('groupe_edit', array('id' => $groupe->getId()));
        }

        return $this->render('groupe/edit.html.twig', array(
            'groupe' => $groupe,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a groupe entity.
     *
     */
    public function deleteAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $groupe=$em->getRepository("GroupeBundle:Groupe")->find($id);
        $em->remove($groupe);
        $em->flush();
        return $this->redirectToRoute('groupe_index');
    }


    /**
     * Creates a form to delete a groupe entity.
     *
     * @param Groupe $groupe The groupe entity
     *
     * @return Form The form
     */
    private function createDeleteForm(Groupe $groupe)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('groupe_delete', array('id' => $groupe->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
