<?php

namespace DonationBundle\Controller;

use DonationBundle\Entity\donation;
use DonationBundle\Entity\facture;
use FOSBundle\Entity\talent;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Facture controller.
 *
 */
class factureController extends Controller
{
    /**
     * Lists all facture entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $factures = $em->getRepository('DonationBundle:facture')->findAll();

        return $this->render('facture/index.html.twig', array(
            'factures' => $factures,
        ));
    }

    /**
     * Creates a new facture entity.
     *
     */
    public function newAction(Request $request ,$id)
    {
        $facture = new Facture();
        $donation= new donation();
        $talent= new talent();
        $em=$this->getDoctrine()->getManager();
       $donation =$em->getRepository("DonationBundle:donation")->find($id);
        //$talent=$em->getRepository("FOSBundle:talent")->find($id);

        $form = $this->createForm('DonationBundle\Form\factureType', $facture);
        $form->handleRequest($request);
        $facture->setUserid($this->getUser());
        $facture->setDonationid($donation);
        $facture->setDateCr(new \DateTime("now"));
        $em->persist($facture);
        $em->flush();
        return $this->redirectToRoute('facture_show', array('id' => $facture->getId()));
        /*if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $facture->setUserid($this->getUser());
            $facture->setDonationid($donation);
            $facture->setDateCr(new \DateTime("now"));
            $em->persist($facture);
            $em->flush();

            return $this->redirectToRoute('facture_show', array('id' => $facture->getId()));
        }

        return $this->render('facture/new.html.twig', array(
            'facture' => $facture,
            'form' => $form->createView(),
        ));*/
    }

    /**
     * Finds and displays a facture entity.
     *
     */
    public function showAction(facture $facture, $id)
    {
        $donation= new donation();
        $deleteForm = $this->createDeleteForm($facture);
        $em=$this->getDoctrine()->getManager();
        $donation = $em->getRepository("DonationBundle:donation")->find($facture->getDonationid());


        return $this->render('facture/show.html.twig', array(
            'donation'=>$donation,
            'facture' => $facture,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing facture entity.
     *
     */
    public function editAction(Request $request, facture $facture)
    {
        $deleteForm = $this->createDeleteForm($facture);
        $editForm = $this->createForm('DonationBundle\Form\factureType', $facture);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('facture_edit', array('id' => $facture->getId()));
        }

        return $this->render('facture/edit.html.twig', array(
            'facture' => $facture,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a facture entity.
     *
     */
    public function deleteAction(Request $request, facture $facture)
    {
        $form = $this->createDeleteForm($facture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($facture);
            $em->flush();
        }

        return $this->redirectToRoute('facture_index');
    }

    /**
     * Creates a form to delete a facture entity.
     *
     * @param facture $facture The facture entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(facture $facture)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('facture_delete', array('id' => $facture->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
