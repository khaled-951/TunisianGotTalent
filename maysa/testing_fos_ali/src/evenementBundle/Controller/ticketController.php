<?php

namespace evenementBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use evenementBundle\Entity\ticket;
use evenementBundle\Entity\evenement;
use evenementBundle\Form\ticketType;
use Symfony\Component\HttpFoundation\Request;

class ticketController extends Controller
{
    public function ajouterticketAction(Request $request, $id)
    {



            $ticket = new ticket();
            $ticket->setDateemission(new \DateTime('now'));
            $em = $this->getDoctrine()->getManager();
            $nom=$em->getRepository('evenementBundle:evenement')->find($id);
            $ticket->setEvenement($nom);
            $em->persist($ticket);
            $em->flush();
            $this->addFlash('success', 'participation avec succees!');
            return $this->redirectToRoute('afficheruser1', array(
                'id' => $id,
           ));













       //



    }
    public function supprimerticketAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $ticket = $em->getRepository("evenementBundle:ticket")->find($id);
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

}
