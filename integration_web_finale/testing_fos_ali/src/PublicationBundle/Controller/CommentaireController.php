<?php

namespace PublicationBundle\Controller;

use PublicationBundle\Entity\Commentaire;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Commentaire controller.
 *
 */
class CommentaireController extends Controller
{
    /**
     * Lists all commentaire entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $commentaires = $em->getRepository('PublicationBundle:Commentaire')->findAll();

        return $this->render('commentaire/index.html.twig', array(
            'commentaires' => $commentaires,
        ));
    }

    public function viewCommentsAction($id_publication)
    {
        $em = $this->getDoctrine()->getManager();

        $commentaires = $em->getRepository('PublicationBundle:Commentaire')->findBy(array("Publication_id"=>$id_publication));

        return $this->render('@Publication/Default/admin_view_comments.html.twig', array(
            'commentaires' => $commentaires,
        ));
    }

    /**
     * Creates a new commentaire entity.
     *
     */
    public function newAction(Request $request, $publication_id)
    {
        $user = $this->getUser() ;
        $commentaire = new Commentaire();
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm('PublicationBundle\Form\CommentaireType', $commentaire);
        $publication = $em->getRepository('PublicationBundle:Publication')->find($publication_id);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $commentaire->setPublicationId($publication);
            $commentaire->setUserIdPublication($user);
            $commentaire->setDateCommentaire(new \DateTime("now", new \DateTimeZone('+0100')));
            $em->persist($commentaire);
            $em->flush();
            return new Response($commentaire->getId());
        }

        return new Response("");

        /*return $this->render('commentaire/new.html.twig', array(
            'commentaire' => $commentaire,
            'form' => $form->createView(),
        ));*/
    }

    /**
     * Finds and displays a commentaire entity.
     *
     */
    public function showAction(Commentaire $commentaire)
    {
        $deleteForm = $this->createDeleteForm($commentaire);

        return $this->render('commentaire/show.html.twig', array(
            'commentaire' => $commentaire,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing commentaire entity.
     *
     */
    public function editAction(Request $request, Commentaire $commentaire)
    {
        $deleteForm = $this->createDeleteForm($commentaire);
        $editForm = $this->createForm('PublicationBundle\Form\CommentaireType', $commentaire);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return new Response($commentaire->getId());
            /*return $this->redirectToRoute('commentaire_edit', array('id' => $commentaire->getId()));*/
        }

        return new Response("");
        /*
        return $this->render('commentaire/edit.html.twig', array(
            'commentaire' => $commentaire,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));*/
    }

    /**
     * Deletes a commentaire entity.
     *
     */
    public function deleteAction($id)
    {
        $user = $this->getUser() ;
        $em = $this->getDoctrine()->getManager();
        $commentaire = $em->getRepository('PublicationBundle:Commentaire')->find($id);

        if ($commentaire && ($commentaire->getUserIdPublication()->getId() == $user->getId() || $user->isSuperAdmin()) ) {
            $em->remove($commentaire);
            $em->flush();
        }

        return new Response("");
    }

    /**
     * Creates a form to delete a commentaire entity.
     *
     * @param Commentaire $commentaire The commentaire entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Commentaire $commentaire)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('commentaire_delete', array('id' => $commentaire->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
