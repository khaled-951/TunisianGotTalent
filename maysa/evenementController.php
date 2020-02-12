<?php

namespace evenementBundle\Controller;

use evenementBundle\Entity\evenement;


use evenementBundle\Form\evenementType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Component\HttpFoundation\Response;

/**
 * Evenement controller.
 *
 * @Route("evenement")
 */
class evenementController extends Controller
{
    /**
     * Lists all evenement entities.
     *
     * @Route("/", name="evenement_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();




        $evenements = $em->getRepository('evenementBundle:evenement')->findAll();




        return $this->render('evenement/index.html.twig', array(
            'evenements' => $evenements,
        ));
    }

    /**
     * Creates a new evenement entity.
     *
     * @Route("/new", name="evenement_new")
     * @Method({"GET", "POST"})
     */


    public function newAction(Request $request)
    {
        $evenement = new Evenement();
        $form = $this->createForm(evenementType::class, $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $evenement->upload();
            $em->persist($evenement);
            $em->flush();
            return $this->redirectToRoute('afficherchasseur');
          //  return $this->redirectToRoute('evenement_show', array('id_evenement' => $evenement->getId_evenement()));
        }


                 return $this->render('evenementBundle:evenement:ajouterevenement.html.twig', array(
                     'evenement' => $evenement,
                     'form' => $form->createView(),
                 ));
        
    }



    /**
     * Finds and displays a evenement entity.
     *
     * @Route("/{id_evenement}", name="evenement_show")
     * @Method("GET")
     */
    public function showAction(evenement $evenement)
    {
        $deleteForm = $this->createDeleteForm($evenement);

        return $this->render('evenement/afficherevenement.html.twig', array(
            'evenement' => $evenement,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing evenement entity.
     *
     * @Route("/{id_evenement}/edit", name="evenement_edit")
     * @Method({"GET", "POST"})
     */
    public function modifierAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $evenement = $em->getRepository("evenementBundle:evenement")->find($id);
        $form = $this->createForm(evenementType::class, $evenement);

        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $evenement->upload();
            $em->persist($evenement);
            $em->flush();
            return $this->redirectToRoute('afficher');
        }
        return $this->render("evenementBundle:evenement:modifierevenement.html.twig", array('form' => $form->createView()));
    }

    /**
     * Deletes a evenement entity.
     *
     * @Route("/{id_evenement}", name="evenement_delete")
     * @Method("DELETE")
     */
    public function supprimerAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $evenement = $em->getRepository("evenementBundle:evenement")->find($id);
        $em->remove($evenement);
        $em->flush();
        return $this->redirectToRoute('afficher');
    }


    public function supprimerAdminAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $evenement = $em->getRepository("evenementBundle:evenement")->find($id);
        $em->remove($evenement);
        $em->flush();
        return $this->redirectToRoute('afficherevenementAdmin');
    }



    /**
     * Creates a form to delete a evenement entity.
     *
     * @param evenement $evenement The evenement entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(evenement $evenement)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('evenement_delete', array('id_evenement' => $evenement->getId_evenement())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    public function afficherAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $evenement=$em->getRepository('evenementBundle:evenement')->findAll();

        return $this->render('evenementBundle:evenement:afficherevenement.html.twig', array(
            'evenement'=>$evenement));
    }
    public function afficherevenementAdminAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $evenement=$em->getRepository('evenementBundle:evenement')->findAll();

        return $this->render('evenementBundle:evenement:afficherevenementAdmin.html.twig', array(
            'evenement'=>$evenement));
    }

    public function detailuserAction(Request $request,$id)
    {
        $em=$this->getDoctrine()->getManager();
        $evenement=$em->getRepository('evenementBundle:evenement')->findBy(array('id_evenement'=>$id));

        return $this->render('evenementBundle:evenement:detailuser.html.twig', array(
            'evenement'=>$evenement));
    }





    public function detailevenementadminAction(Request $request,$id)
    {
        $em=$this->getDoctrine()->getManager();
        $evenement=$em->getRepository('evenementBundle:evenement')->findBy(array('id_evenement'=>$id));
        return $this->render('evenementBundle:evenement:detailevenementadmin.html.twig', array(
            'evenement'=>$evenement));
    }







    public function afficheruserAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $evenement=$em->getRepository('evenementBundle:evenement')->findAll();


        foreach ($evenement as $evt) {

            $participations = $em->getRepository('evenementBundle:ticket')->findBy(array('evenement'=>$evt->getIdEvenement()));

            if(count($participations)>0) {
                $evt->setParticipe(true);
            }
            else{
                $evt->setParticipe(false);
            }


            // $forum->setCountComments(count($comments));

        }

        //var_dump($evenement);

       // $ticket=$em->getRepository('evenementBundle:ticket')->findBy(array('evenement'=>$id));

                return $this->render('evenementBundle:evenement:afficherevenementuser.html.twig', array(
                    'evenement'=>$evenement));


    }


    public function afficheruser1Action(Request $request,$id)
    {
        $em=$this->getDoctrine()->getManager();
        $evenement=$em->getRepository('evenementBundle:evenement')->findBy(array('id_evenement'=>$id));
        $ticket=$em->getRepository('evenementBundle:ticket')->findBy(array('evenement'=>$id));


        //var_dump($ticket);


                return $this->render('evenementBundle:evenement:afficherevenementuser1.html.twig', array(
                    'evenement' => $evenement, 'ticket' => $ticket));

        }




























    public function pdfAction()
    {

        // $ id tu vas recuperer la ticket mel base get doctrime findby
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('evenementBundle:ticket:ticket.html.twig', [
            'title' => "Welcome to our PDF Test"
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A3', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (inline view)
        $dompdf->stream("mypdf.pdf", [
            "Attachment" => false
        ]);
    }







}
