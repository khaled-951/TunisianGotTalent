<?php

namespace SponsorsBundle\Controller;

use SponsorsBundle\Entity\Pack;
use SponsorsBundle\Form\PackType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class PackController extends Controller
{
    public function newAction(Request $request)
    {
        $pack = new Pack();
        $form = $this->createForm('SponsorsBundle\Form\PackType', $pack);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($pack);
            $em->flush();

            return $this->redirectToRoute('pack_show', array('idad' => $pack->getIdad()));
        }

        return $this->render('@Sponsors/Pack/new.html.twig', array(
            'pack' => $pack,
            'form' => $form->createView(),
        ));

    }

    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $packs = $em->getRepository('SponsorsBundle:Pack')->findAll();

        return $this->render('@Sponsors/Pack/index.html.twig', array(
            'packs' => $packs,
        ));

    }

    /**
     * Finds and displays a pack entity.
     *
     * @Route("/{idad}", name="pack_show")
     * @Method("GET")
     */
    public function showAction($idad)
    {

        $em = $this->getDoctrine()->getManager();

        $pack = $em->getRepository('SponsorsBundle:Pack')->find($idad);
        return $this->render('@Sponsors/Pack/show.html.twig', array(
            'pack' => $pack,

        ));

    }
    /**
     * Displays a form to edit an existing pack entity.
     *
     * @Route("/{idad}", name="pack_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, $idad)
    {
        $pack = $this->getDoctrine()->getRepository(Pack::class)->find($idad);
        $form = $this->createForm(PackType::class, $pack);
        $form =$form->handleRequest($request);
        if($form->isSubmitted()){
            $em=$this->getDoctrine()->getManager();
            $em->persist($pack);
            $em->flush();
            return $this->redirectToRoute('pack_index');
        }
        return $this->render('@Sponsors/Pack/edit.html.twig', array('form'=>$form->createView()));

    }

}
