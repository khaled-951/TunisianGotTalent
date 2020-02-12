<?php

namespace GroupeBundle\Controller;

use GroupeBundle\Entity\Replies;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Reply controller.
 *
 */
class RepliesController extends Controller
{
    /**
     * Lists all reply entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $replies = $em->getRepository('GroupeBundle:Replies')->findAll();

        return $this->render('replies/index.html.twig', array(
            'replies' => $replies,
        ));
    }

    /**
     * Creates a new reply entity.
     *
     */
    public function newAction(Request $request)
    {
        $reply = new Replies();
        $form = $this->createForm('GroupeBundle\Form\RepliesType', $reply);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($reply);
            $em->flush();

            return $this->redirectToRoute('replies_show', array('id' => $reply->getId()));
        }

        return $this->render('replies/new.html.twig', array(
            'reply' => $reply,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a reply entity.
     *
     */
    public function showAction(Replies $reply)
    {
        $deleteForm = $this->createDeleteForm($reply);

        return $this->render('replies/show.html.twig', array(
            'reply' => $reply,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing reply entity.
     *
     */
    public function editAction(Request $request, Replies $reply)
    {
        $deleteForm = $this->createDeleteForm($reply);
        $editForm = $this->createForm('GroupeBundle\Form\RepliesType', $reply);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('replies_edit', array('id' => $reply->getId()));
        }

        return $this->render('replies/edit.html.twig', array(
            'reply' => $reply,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a reply entity.
     *
     */
    public function deleteAction(Request $request, Replies $reply)
    {
        $form = $this->createDeleteForm($reply);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($reply);
            $em->flush();
        }

        return $this->redirectToRoute('replies_index');
    }

    /**
     * Creates a form to delete a reply entity.
     *
     * @param Replies $reply The reply entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Replies $reply)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('replies_delete', array('id' => $reply->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
