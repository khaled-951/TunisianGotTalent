<?php

namespace SponsorsBundle\Controller;

use SponsorsBundle\Entity\Sponsor;

use SponsorsBundle\Form\SponsorType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class SponsorController extends Controller
{
    public function newAction(Request $request)
    {
        $sponsor = new Sponsor();
        $form = $this->createForm('SponsorsBundle\Form\SponsorType', $sponsor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var UploadedFile $logo */
            $logo = $form->get('logo')->getData();


            if ($logo) {
                $originalFilename = pathinfo($logo->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$logo->guessClientExtension();


                try {
                    $logo->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                }

                $sponsor->setLogo($newFilename);
            }


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
        $sponsor->setLogo(new File($this->getParameter('images_directory').'/'.$sponsor->getLogo()));
        $form = $this->createForm(SponsorType::class, $sponsor);

        $form =$form->handleRequest($request);

        if($form->isSubmitted()){
            /** @var UploadedFile $logo */
            $logo = $form->get('logo')->getData();


            if ($logo) {
                $originalFilename = pathinfo($logo->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$logo->guessClientExtension();


                try {
                    $logo->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                }

                $sponsor->setLogo($newFilename);
            }

            $em=$this->getDoctrine()->getManager();
            $em->persist($sponsor);
            $em->flush();
            return $this->redirectToRoute('sponsor_index');
        }

        $user=$this->getUser();
        if($user)
        {
            if($user->isSuperAdmin() )
                return $this->render('@Sponsors/Sponsor/edit.html.twig', array('form'=>$form->createView()));

        }

    }

    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $sponsors = $em->getRepository('SponsorsBundle:Sponsor')->findAll();
        $user=$this->getUser();
        if($user)
        {
            if($user->isSuperAdmin() )
                return $this->render('@Sponsors/Sponsor/index.html.twig', array(
                    'sponsors' => $sponsors,


                ));



        }


    }


    public function user_indexAction(){
        $em = $this->getDoctrine()->getManager();

        $sponsors = $em->getRepository('SponsorsBundle:Sponsor')->findAll();

        return $this->render('@Sponsors/Sponsor/user_index.html.twig', array(
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

        $user=$this->getUser();
        if($user)
        {
            if($user->isSuperAdmin() )
                return $this->render('@Sponsors/Sponsor/show.html.twig', array(
                    'sponsor' => $sponsor,
                    'packs'=>$packs,
                ));

        }



    }


    public function user_showAction($idsp)
    {
        $em = $this->getDoctrine()->getManager();

        $sponsor = $em->getRepository('SponsorsBundle:Sponsor')->find($idsp);
        $packs =  $em->getRepository('SponsorsBundle:Pack')->findBy(array('idsp'=>$idsp));
        return $this->render('@Sponsors/Sponsor/user_show.html.twig', array(
            'sponsor' => $sponsor,
            'packs'=>$packs,
        ));


    }
    public function inboxAction()
    {
        return $this->render('@Sponsors/Sponsor/admin_inbox.html.twig');
    }
    /**
     * Displays a form to edit an existing pack entity.
     *
     * @Route("/{idsp}", name="sponsor_delete")
     * @Method({"GET"})
     */
    public  function deleteAction($idsp)
    {

        $em =$this->getDoctrine()->getManager();
        $form=$em->getRepository(Sponsor::class)->find($idsp);
        $em->remove($form);
        $em->flush();
        $user=$this->getUser();
        if($user)
        {
            if($user->isSuperAdmin() )
                return $this->redirectToRoute('sponsor_index');
        }



    }

}
