<?php

namespace SponsorsBundle\Controller;

use SponsorsBundle\Entity\Pack;
use SponsorsBundle\Form\PackType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class PackController extends Controller
{
    public function newAction(Request $request)
    {
        //test de places
        $pack = new Pack();
        $form = $this->createForm('SponsorsBundle\Form\PackType', $pack);
        $form->handleRequest($request);

        $em = $this->getDoctrine()->getManager();
        $left=$em->getRepository('SponsorsBundle:Pack')->adsLeftQB();
        $right=$em->getRepository('SponsorsBundle:Pack')->adsRightQB();
        if($right>=2)
            $right='disabled';
        if($left>=2)
            $left='disabled';
        if ($form->isSubmitted() ) {
            /** @var UploadedFile $ad */
            $ad = $form->get('ad')->getData();
            if ($ad) {
                $originalFilename = pathinfo($ad->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $ad->guessClientExtension();
                try {
                    $ad->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                }
                $pack->setAd($newFilename);
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($pack);
            $em->flush();

            return $this->redirectToRoute('pack_show', array('idad' => $pack->getIdad()));
        }

        $user=$this->getUser();
        if($user)
        {
            if($user->isSuperAdmin() )
                return $this->render('@Sponsors/Pack/new.html.twig', array(
                    'pack' => $pack,

                    'form' => $form->createView(),
                ));
            else
                return $this->render('@Sponsors/Sponsor/error500.html.twig');
        }


    }

    public function indexAction(Request $request)
    {
        //test de date if date today is between diplay date and discard date --> show + state (programmed/displaying/history)
        $em = $this->getDoctrine()->getManager();

        $packs = $em->getRepository('SponsorsBundle:Pack')->editCurrentAdQB();
        $packs = $em->getRepository('SponsorsBundle:Pack')->editHistoryAdQB();
        $packs = $em->getRepository('SponsorsBundle:Pack')->editProgAdQB();

        $packs = $em->getRepository('SponsorsBundle:Pack')->findAll();

        $paginator= $this->get('knp_paginator');
        $res =$paginator->paginate(
            $packs,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 5)

        );

        $user=$this->getUser();
        if($user)
        {
            if($user->isSuperAdmin() )
                return $this->render('@Sponsors/Pack/index.html.twig', array(
                    'packs' => $res,
                ));
            else
                return $this->render('@Sponsors/Sponsor/error500.html.twig');
        }



    }


    public function showAction($idad)
    {

        $em = $this->getDoctrine()->getManager();


        $pack = $em->getRepository('SponsorsBundle:Pack')->find($idad);
        $user=$this->getUser();
        if($user)
        {
            if($user->isSuperAdmin() )
                return $this->render('@Sponsors/Pack/show.html.twig', array(
                    'pack' => $pack,

                ));
            else
                return $this->render('@Sponsors/Sponsor/error500.html.twig');
        }



    }

    public function editAction(Request $request, $idad)
    {
        $pack = $this->getDoctrine()->getRepository(Pack::class)->find($idad);
        $pack->setAd(new File('uploads/images/11-5e440b974a910.jpeg'));


        $form = $this->createForm(PackType::class, $pack);
        $form =$form->handleRequest($request);
        if($form->isSubmitted()){


            $ad = $form->get('ad')->getData();


            if ($ad) {
                $originalFilename = pathinfo($ad->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $ad->guessClientExtension();


                try {
                    $ad->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                }

                $pack->setAd($newFilename);


            }

            $em=$this->getDoctrine()->getManager();
            $em->persist($pack);
            $em->flush();
            return $this->redirectToRoute('pack_index');
        }

        $user=$this->getUser();
        if($user)
        {
            if($user->isSuperAdmin() )
                return $this->render('@Sponsors/Pack/edit.html.twig', array('form'=>$form->createView()));
            else
                return $this->render('@Sponsors/Sponsor/error500.html.twig');
        }

    }


    public  function deleteAction($idad)
    {

        $em =$this->getDoctrine()->getManager();
        $form=$em->getRepository(Pack::class)->find($idad);
        $em->remove($form);
        $em->flush();
        $user=$this->getUser();
        if($user)
        {
            if($user->isSuperAdmin() )
                return $this->redirectToRoute('pack_index');

            else
                return $this->render('@Sponsors/Sponsor/error500.html.twig');
        }

    }

}
