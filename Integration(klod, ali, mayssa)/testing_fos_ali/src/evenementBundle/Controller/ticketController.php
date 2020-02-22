<?php

namespace evenementBundle\Controller;

use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use evenementBundle\Entity\ticket;
use evenementBundle\Entity\evenement;
use evenementBundle\Form\ticketType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ticketController extends Controller
{
    public function ajouterticketAction(Request $request, $id)
    {



            $ticket = new ticket();
            $ticket->setDateemission(new \DateTime('now'));

            $em = $this->getDoctrine()->getManager();
        $evenement=$em->getRepository("evenementBundle:evenement")->find($id);

        $message = new \DocDocDoc\NexmoBundle\Message\Simple("Tunisian GT", "21652376526", "je vous souhaite la bienvenue au sein de notre evenement");
        $nexmoResponse = $this->container->get('doc_doc_doc_nexmo')->send($message);

        $nbp=$evenement->getNbparticipant();
        $evenement->setNbparticipant($nbp-1);


            $nom=$em->getRepository('evenementBundle:evenement')->find($id);
            $ticket->setEvenement($nom);
            $em->persist($ticket);
            $em->flush();


            $this->addFlash('success', 'participation avec succees!');
            return $this->redirectToRoute('afficheruser1', array(
                'id' => $id,
           ));

















    }
    public function supprimerticketAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $ticket = $em->getRepository("evenementBundle:ticket")->find($id);

        $nbp=$ticket->getEvenement()->getNbparticipant();
        $ticket->getEvenement()->setNbparticipant($nbp+1);
        $message = new \DocDocDoc\NexmoBundle\Message\Simple("Tunisian GT", "21652376526", "votre participation a ete annulée");
        $nexmoResponse = $this->container->get('doc_doc_doc_nexmo')->send($message);
        $em->remove($ticket);
        $em->flush();
        return $this->redirectToRoute('afficheruser');

    }





    public function consulterticketAction(Request $request,$id)
    {
        $em=$this->getDoctrine()->getManager();
        $ticket=$em->getRepository('evenementBundle:ticket')->findBy(array('evenement'=>$id));

        return $this->render('evenementBundle:ticket:consulterticket.html.twig', array(
            'ticket'=>$ticket));
    }




    public function pdfAction($id,Request $request)

    {

        $em=$this->getDoctrine()->getManager();
        $ticket = $em->getRepository('evenementBundle:ticket')->find($id);
        $evenement = $em->getRepository('evenementBundle:ticket')->find($id);
        // $ id tu vas recuperer la ticket mel base get doctrime findby
        // Configure Dompdf according to your needs
        $options = new Options();
        // Pour simplifier l'affichage des images, on autorise dompdf à utiliser
        // des  url pour les nom de  fichier
        $options->set('isRemoteEnabled', true);
        // On crée une instance de dompdf avec  les options définies
        $dompdf = new Dompdf($options);

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('evenementBundle:ticket:ticket.html.twig', array(

            'ticket'=>$ticket,
            'evenement'=>$evenement

        ));


        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'


        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (inline view)
        return new Response ($dompdf->stream());

    }









}
