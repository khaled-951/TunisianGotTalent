<?php

namespace ReclamationBundle\Controller;

use ReclamationBundle\Entity\avis;
use ReclamationBundle\Form\avisType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class avisController extends Controller
{
    public function createAction(Request $request)
    {
        $avis= new avis();
        $form = $this->createForm(avisType::class, $avis);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($avis);
            $em->flush();
            return $this->redirectToRoute('readreclamation');
        }

        return $this->render('@Reclamation/Default/rating.html.twig', array(
            'avis' => $avis,
            'form' => $form->createView(),
        ));
    }
    public function afficherAction()
    {
        $em=$this->getDoctrine()->getRepository(avis::class)->findAll();
        return $this->render('@Reclamation/Dashboard/dashboardavis.html.twig',array('avis'=> $em));
    }
    function deleteAction($id){
        $em=$this->getDoctrine()->getManager();
        $avis=$this->getDoctrine()->getRepository(avis::class)
            ->find($id);
        $em->remove($avis);
        $em->flush();
        return $this->redirectToRoute('avis');
    }
}
