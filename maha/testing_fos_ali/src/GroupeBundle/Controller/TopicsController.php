<?php

namespace GroupeBundle\Controller;

use Exception;
use GroupeBundle\Entity\Groupe;
use GroupeBundle\Entity\Replies;
use GroupeBundle\Entity\Topics;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Topic controller.
 *
 */
class TopicsController extends Controller
{
    /**
     * Lists all topic entities.
     *
     */
    public function indexAction($groupe_id)
    {
        $em = $this->getDoctrine()->getManager();
        $topics = $em->getRepository('GroupeBundle:Topics')->findTopic($groupe_id);

        return $this->render('topics/index.html.twig', array(
            'topics' => $topics,
            'groupe_id'=>$groupe_id,
        ));
    }

    /**
     * Creates a new topic entity.
     *
     */
    public function newAction(Request $request,$groupe_id)
    {
        $topic = new Topics();
        $topic->setTopicBy($this->getUser()->getUsername());
        $form = $this->createForm('GroupeBundle\Form\TopicsType', $topic);
        $groupe=  $this->getDoctrine()->getManager()->getRepository('GroupeBundle:Groupe')->find($groupe_id);
        $topic->setGroupe($groupe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($topic);
            $em->flush();

            return $this->redirectToRoute('topics_show', array('id' => $topic->getId(),'groupe_id'=>$groupe_id));
        }

        return $this->render('topics/new.html.twig', array(
            'topic' => $topic,
            'form' => $form->createView(),
            'groupe_id'=>$groupe_id
        ));
    }


    public function showAction(Topics $topic)
    {
        $deleteForm = $this->createDeleteForm($topic);
        $replies=$this->getDoctrine()->getManager()->getRepository('GroupeBundle:Replies')->findReplies($topic->getId());

        return $this->render('topics/show.html.twig', array(
            'replies'=>$replies,
            'topic' => $topic,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing topic entity.
     *
     */
    public function editAction(Request $request, Topics $topic)
    {
        $deleteForm = $this->createDeleteForm($topic);
        $editForm = $this->createForm('GroupeBundle\Form\TopicsType', $topic);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('topics_edit', array('id' => $topic->getId(),'groupe_id'=>$topic->getGroupe()->getId()));
        }

        return $this->render('topics/edit.html.twig', array(
            'topic' => $topic,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'groupe_id'=>$topic->getGroupe()->getId(),
        ));
    }

    /**
     * Deletes a topic entity.
     *
     */
    public function deleteAction(Request $request, Topics $topic)
    {
        $form = $this->createDeleteForm($topic);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($topic);
            $em->flush();
        }

        return $this->redirectToRoute('topics_index');
    }

    /**
     * Creates a form to delete a topic entity.
     *
     * @param Topics $topic The topic entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Topics $topic)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('topics_delete', array('id' => $topic->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
