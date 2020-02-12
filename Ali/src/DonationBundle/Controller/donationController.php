<?php

namespace DonationBundle\Controller;

use DonationBundle\Entity\donation;
use DonationBundle\Entity\facture;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Donation controller.
 *
 */
class donationController extends Controller
{
    /**
     * Lists all donation entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $donations = $em->getRepository('DonationBundle:donation')->findAll();
       $user=$this->getUser();
        if($user)
        {

            if(!($user->isSuperAdmin()))
                return $this->render('donation/index.html.twig', array(
                    'donations' => $donations,
                ));
        }
       /* return $this->render('donation/index.html.twig', array(
            'donations' => $donations,
        ));*/
    }
    public function index2Action()
    {
        $em = $this->getDoctrine()->getManager();

        $donations = $em->getRepository('DonationBundle:donation')->findAll();
        $user=$this->getUser();
        if($user)
        {
            if($user->isSuperAdmin() )

                return $this->render('donation/index2.html.twig', array(
                    'donations' => $donations,
                ));


        }

    }
    /**
     * Creates a new donation entity.
     *
     */
    public function newAction(Request $request)
    {
        $donation = new Donation();
        $form = $this->createForm('DonationBundle\Form\donationType', $donation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $donation->UploadProfilePicture();
            $donation->setUserid($this->getUser());

            $em->persist($donation);
            $em->flush();

            return $this->redirectToRoute('donation_show', array('id' => $donation->getId()));
        }

        return $this->render('donation/new.html.twig', array(
            'donation' => $donation,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a donation entity.
     *
     */
    public function showAction(donation $donation)
    {
        $deleteForm = $this->createDeleteForm($donation);

        return $this->render('donation/show.html.twig', array(
            'donation' => $donation,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing donation entity.
     *
     */
    public function editAction(Request $request, donation $donation)
    {
        $deleteForm = $this->createDeleteForm($donation);
        $editForm = $this->createForm('DonationBundle\Form\donationType', $donation);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $donation->UploadProfilePicture();
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('donation_edit', array('id' => $donation->getId()));
        }

        return $this->render('donation/edit.html.twig', array(
            'donation' => $donation,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    public function edit2Action(Request $request, donation $donation)
    {
        $deleteForm = $this->createDeleteForm($donation);
        $editForm = $this->createForm('DonationBundle\Form\donationType', $donation);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('donation_edit2', array('id' => $donation->getId()));
        }

        return $this->render('donation/edit2.html.twig', array(
            'donation' => $donation,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a donation entity.
     *
     */
    public function deleteAction( $id)
    {
        $em=$this->getDoctrine()->getManager();
        $donation=$em->getRepository("DonationBundle:donation")->find($id);
        $em->remove($donation);
        $em->flush();
        return $this->redirectToRoute('donation_index');




    }
   /* public function delete2Action($id)
    {
        $em=$this->getDoctrine()->getManager();
        $donation=$em->getRepository("BallProjetBundle:Projet")->find($id);
        $form = $this->createDeleteForm($donation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($donation);
            $em->flush();
        }

        return $this->redirectToRoute('donation_index2');
    }*/
    public function delete2Action($id)
    {


        $em=$this->getDoctrine()->getManager();
        $donation=$em->getRepository("DonationBundle:donation")->find($id);
        $em->remove($donation);
        $em->flush();
        return $this->redirectToRoute('donation_index2');
    }

    /**
     * Creates a form to delete a donation entity.
     *
     * @param donation $donation The donation entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(donation $donation)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('donation_delete', array('id' => $donation->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
