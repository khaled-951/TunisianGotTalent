<?php

namespace SponsorsBundle\Controller;

use SponsorsBundle\Entity\Sponsor;

use SponsorsBundle\Form\SponsorType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class SponsorController extends Controller
{
    public function newAction(Request $request)
    {
        $sponsor = new Sponsor();
        $form = $this->createForm('SponsorsBundle\Form\SponsorType', $sponsor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($sponsor);
            $em->flush();

            return $this->redirectToRoute('sponsor_show', array('idsp' => $sponsor->getIdsp()));
        }

        return $this->render('@Sponsors/Sponsor/new.html.twig', array(
            'sponsor' => $sponsor,
            'form' => $form->createView(),
        ));

    }


    /**
     * Displays a form to edit an existing sponsor entity.
     *
     * @Route("/{idsp}/edit", name="sponsor_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, $idsp)
    {
        $sponsor = $this->getDoctrine()->getRepository(Sponsor::class)->find($idsp);
        $form = $this->createForm(SponsorType::class, $sponsor);
        $form =$form->handleRequest($request);
        if($form->isSubmitted()){
            $em=$this->getDoctrine()->getManager();
            $em->persist($sponsor);
            $em->flush();
            return $this->redirectToRoute('sponsor_index');
        }
        return $this->render('@Sponsors/Sponsor/edit.html.twig', array('form'=>$form->createView()));

    }

    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $sponsors = $em->getRepository('SponsorsBundle:Sponsor')->findAll();

        return $this->render('@Sponsors/Sponsor/index.html.twig', array(
            'sponsors' => $sponsors,
        ));

    }

    /**
     * Finds and displays a sponsor entity.
     *
     * @Route("/{idsp}", name="sponsor_show")
     * @Method("GET")
     */
    public function showAction($idsp)
    {
        $em = $this->getDoctrine()->getManager();

        $sponsor = $em->getRepository('SponsorsBundle:Sponsor')->find($idsp);
        $packs =  $em->getRepository('SponsorsBundle:Pack')->findBy(array('idsp'=>$idsp));
        return $this->render('@Sponsors/Sponsor/show.html.twig', array(
            'sponsor' => $sponsor,
            'packs'=>$packs,
        ));


    }

}
