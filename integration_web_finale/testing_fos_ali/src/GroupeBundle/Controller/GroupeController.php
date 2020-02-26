<?php

namespace GroupeBundle\Controller;

use Cassandra\Date;
use Doctrine\Common\Collections\ArrayCollection;
use FOSBundle\Entity\User;
use GroupeBundle\Entity\Demande;
use GroupeBundle\Entity\Groupe;
use GroupeBundle\Entity\Rate;
use GroupeBundle\Entity\Topics;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\DateTime;

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
    public function indexAction(Request $request)
    {
        $em1 = $this->getDoctrine()->getManager();
        $em = $this->getDoctrine()->getManager();
        $groupes = $em1->getRepository('GroupeBundle:Groupe')->findAll();
        $demandes = $em->getRepository('GroupeBundle:Demande')->findAll();
        $paginator=$this->get('knp_paginator');
       $pagination = $paginator->paginate(
          $groupes,
          $request->query->getInt('page',1),
           $request->query->getInt('limit',5 )
        );
       // $pagination->setTemplate('GroupeBundle:Default:pagination.html.twig');
        $user=$this->getUser();
        if($user)
        {
            if(!$user->isSuperAdmin()){
        return $this->render('groupe/show.html.twig', array(
            'groupes' => $pagination,
            'demandes'=>$demandes
        ));
    }}}

    public function index2Action()
    {
        $em = $this->getDoctrine()->getManager();

        $groupes = $em->getRepository('GroupeBundle:Groupe')->findAll();
        $user=$this->getUser();
        if($user)
        {
            if($user->isSuperAdmin()){
                return $this->render('groupe/index2.html.twig', array(
                    'groupes' => $groupes,
                ));}
        }}

    public function demandeAction(Request $request,$id)
    {
        $demande = new Demande();
        $demande->setUser($this->getUser());
        $groupe=new Groupe();
        $groupe= $this->getDoctrine()->getRepository(Groupe::class)->find($id);
        $demande->setGroupe($groupe);
        $em = $this->getDoctrine()->getManager();
        $em->persist($demande);
        $em->flush();

        $em1 = $this->getDoctrine()->getManager();
        $em2 = $this->getDoctrine()->getManager();
        $groupes = $em1->getRepository('GroupeBundle:Groupe')->findAll();
        $demandes = $this->getDoctrine()->getManager()->getRepository('GroupeBundle:Demande')->findAll();
        $paginator=$this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $groupes,
            $request->query->getInt('page',1),
            $request->query->getInt('limit',5 )
        );
        // $pagination->setTemplate('GroupeBundle:Default:pagination.html.twig');
        $user=$this->getUser();
        if($user)
        {
            if(!$user->isSuperAdmin()){
                return $this->render('groupe/show.html.twig', array(
                    'groupes' => $pagination,
                    'demandes'=>$demandes
                ));
            }}}




    public function acceptAction($id_groupe,$id_user,$id,Request $request)
    {       $groupe= $this->getDoctrine()->getRepository(Groupe::class)->find($id_groupe);
            $user = $this->getDoctrine()->getRepository(User::class)->find(1);
            $user->addgroupe($groupe);
            $demande = $this->getDoctrine()->getRepository(Demande::class)->find($id);
            $em = $this->getDoctrine()->getManager();
            $em->remove($demande);
            $em->flush();
        $groupes = $em->getRepository('GroupeBundle:Groupe')->findAll();
        $paginator=$this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $groupes,
            $request->query->getInt('page',1),
            $request->query->getInt('limit',5 )
        );
            $demandes = $em->getRepository('GroupeBundle:Demande')->findAll();

        return $this->redirectToRoute('groupe_index', array(
            'groupes' => $pagination,
            'demandes'=>$demandes,
        ));}


    public function detailAction($id_groupe)
    {
        $groupe= $this->getDoctrine()->getRepository(Groupe::class)->find($id_groupe);
        return $this->render('groupe/publication.html.twig', array(
            'groupe'=>$groupe,
        ));

    }
    public function demandesAction()
    {
        $em = $this->getDoctrine()->getManager();
        $demandes = $em->getRepository('GroupeBundle:Demande')->findAll();

        return $this->render('groupe/show.html.twig', array(
            'demandes' => $demandes,
        ));
    }

    public function groupsAction()
    {
        $em = $this->getDoctrine()->getManager();

        $groupes = $em->getRepository('GroupeBundle:Groupe')->findAll();
        $user=$this->getUser();
        if($user)
        {
            if(!$user->isSuperAdmin()){
        return $this->render('groupe/show.html.twig', array(
            'groupes' => $groupes,
        ));}}
    }
    public function groups2Action()
    {
        $em = $this->getDoctrine()->getManager();

        $groupes = $em->getRepository('GroupeBundle:Groupe')->findAll();
        $user=$this->getUser();
        if($user)
        {
            if($user->isSuperAdmin()){
        return $this->render('groupe/show.html.twig', array(
            'groupes' => $groupes,
        ));
    }}}

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
            $groupe->UploadProfilePicture();
            $groupe->setDateCreation(new \DateTime("now"));
            $em->persist($groupe);
            $em->flush();

            $em = $this->getDoctrine()->getManager();

            $demandes = $this->getDoctrine()->getManager()->getRepository('GroupeBundle:Demande')->findAll();

            $groupes = $em->getRepository('GroupeBundle:Groupe')->findAll();

            $paginator=$this->get('knp_paginator');
            $pagination = $paginator->paginate(
                $groupes,
                $request->query->getInt('page',1),
                $request->query->getInt('limit',5 )
            );
            $user=$this->getUser();
            if($user)
            {
                if(!$user->isSuperAdmin()){
                    return $this->redirectToRoute('groupe_index', array(
                        'groupes' => $pagination,
                        'demandes'=>$demandes,
                    ));}}


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
            $groupe->UploadProfilePicture();
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
        $user=$this->getUser();
        if($user)
        {
            if(!$user->isSuperAdmin()){
        $em=$this->getDoctrine()->getManager();
        $groupe=$em->getRepository("GroupeBundle:Groupe")->find($id);
        $em->remove($groupe);
        $em->flush();
        return $this->redirectToRoute('groupe_index');
    }}}
    public function delete2Action($id)
    {
        $user=$this->getUser();
        if($user)
        {
            if($user->isSuperAdmin()){
                $em=$this->getDoctrine()->getManager();

        $groupe=$em->getRepository("GroupeBundle:Groupe")->find($id);
        $em->remove($groupe);
        $em->flush();}
        return $this->redirectToRoute('groupe_index2');
    }}

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
