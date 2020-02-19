<?php

namespace DonationBundle\Controller;

use DonationBundle\Entity\donation;
use DonationBundle\Entity\facture;
use FOSBundle\Entity\talent;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;


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
        $usr=$facture->getUserid($this->getUser());
        $facture->setDonationid($donation);
        $facture->setDateCr(new \DateTime("now"));
        if($usr->getNbDiamants()>=($donation->getValeurD())) {
            $usr->setNbDiamants($usr->getNbDiamants() - ($donation->getValeurD()));
            $donation->setHidden('0');
            $em->persist($facture);
            $em->flush();
        }
            else if ($usr->getNbDiamants()< $donation->getValeurD())
            {
                return new Response('Nombre de diamants insuffisant');
            }

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
    public function pdfAction(Request $request, $id)
    {
        $donation=new donation();
        $facture = new facture();
        $em=$this->getDoctrine()->getManager();
        $facture= $em->getRepository("DonationBundle:facture")->find($id);
        $donation = $em->getRepository("DonationBundle:donation")->find($facture->getDonationid());

        $snappy = $this->get('knp_snappy.pdf');
        $snappy->setOption('no-outline', true);
        $snappy->setOption('page-size','LETTER');
        $snappy->setOption('encoding', 'UTF-8');

        $html = $this->renderView('facture/pdf.html.twig', array(
            'donation'=>$donation,
            'facture' => $facture,
        ));

        $filename = 'myFirstSnappyPDF';

        return new Response(
            $snappy->getOutputFromHtml($html),
            200,
            array(
                'Content-Type'          => 'application/pdf',
                'Content-Disposition'   => 'inline; filename="'.$filename.'.pdf"'
            )
        );
    }
    public function pdf2Action()
    {
        $snappy = $this->get('knp_snappy.pdf');
        $filename = 'myFirstSnappyPDF';

        // use absolute path !
        $pageUrl = $this->generateUrl('facture_index', array(), UrlGeneratorInterface::ABSOLUTE_URL);

        return new Response(
            $snappy->getOutput($pageUrl),
            200,
            array(
                'Content-Type'          => 'application/pdf',
                'Content-Disposition'   => 'inline; filename="'.$filename.'.pdf"'
            )
        );
    }
    public function NotifAction(Request $request)
    {   $annonceTrouvee=array();
        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
       // $facture= $em->getRepository("DonationBundle:facture")->find($id);
        $donation = $em->getRepository("DonationBundle:donation")->find($user->getUser());
        foreach ($facture as $annonce)
        { foreach ($donation as $alerte)
        {
            if(($annonce->getDonationid()==$alerte->getId())  )
            {
                $annonceTrouvee[]=$annonce;
                //  var_dump($annonceTrouvee);
                $erreur="trouvee";

                $manager = $this->get('mgilet.notification');
                $notif = $manager->generateNotification('Annonce trouvee !');
                $notif->setMessage('This a notification.');
                $notif->setLink('http://symfony.com/');
                $manager->addNotification($this->getUser(), $notif);
                return $this->redirectToRoute('Mes_Alertes_page');


            }
            else{

                $erreur="vous n'avez aucune notification";
            }

        }

        }
        return $this->render('DonationBundle:Default:template.html.twig',array('erreur'=>$erreur, 'annonce'=>$annonceTrouvee));
    }

    private function createDeleteForm(facture $facture)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('facture_delete', array('id' => $facture->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
