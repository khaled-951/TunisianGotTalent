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


        $user=$this->getUser();
        if($user)
        {
            if($user->isSuperAdmin() )
                return $this->render('@Sponsors/Sponsor/new.html.twig', array(
                    'sponsor' => $sponsor,
                    'form' => $form->createView(),
                ));
            else
                return $this->render('@Sponsors/Sponsor/error500.html.twig');


        }



    }


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
            else
                return $this->render('@Sponsors/Sponsor/error500.html.twig');
        }


    }

    public function indexAction( Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $sponsors = $em->getRepository('SponsorsBundle:Sponsor')->findAll();

        $dql   = "SELECT s FROM SponsorsBundle:Sponsor s";
        $query = $em->createQuery($dql);

        /**
         * @var $paginator \Knp\Component\Pager\Paginator
         */
        $paginator= $this->get('knp_paginator');
        $res =$paginator->paginate(
            $sponsors,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 5)

        );


        $user=$this->getUser();
        if($user)
        {
            if($user->isSuperAdmin() )
                return $this->render('@Sponsors/Sponsor/index.html.twig', array(
                    'sponsors' => $res,

                ));
            else
                return $this->render('@Sponsors/Sponsor/error500.html.twig');
        }



    }


    public function user_indexAction(){
        $em = $this->getDoctrine()->getManager();

        $sponsors = $em->getRepository('SponsorsBundle:Sponsor')->findAll();

        return $this->render('@Sponsors/Sponsor/user_index.html.twig', array(
            'sponsors' => $sponsors,
        ));
    }

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
            else
                return $this->render('@Sponsors/Sponsor/error500.html.twig');

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
            else
                return $this->render('@Sponsors/Sponsor/error500.html.twig');
        }



    }

    public function dashAction()
    {
        $em = $this->getDoctrine()->getManager();
        $totSp=$em->getRepository('SponsorsBundle:Sponsor')->spQB();
        $totPack=$em->getRepository('SponsorsBundle:Pack')->packsQB();
        $sumPack=$em->getRepository('SponsorsBundle:Pack')->sumQB();
        $pubSponsor=$em->getRepository('SponsorsBundle:Pack')->pubparsponsorQB();
        $ad1=$em->getRepository('SponsorsBundle:Pack')->ad1QB();
        $ad2=$em->getRepository('SponsorsBundle:Pack')->ad2QB();
        return $this->render('@Sponsors/Sponsor/admin.html.twig', array(
            'sponsors' => $totSp,
            'packs'=>$totPack,
            'sum'=>$sumPack,
            'pub'=>$pubSponsor,
            'ad1'=>$ad1,
            'ad2'=>$ad2
        ));

    }

}
