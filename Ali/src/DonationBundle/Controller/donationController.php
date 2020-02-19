<?php

namespace DonationBundle\Controller;

use DonationBundle\Entity\donation;
use DonationBundle\Entity\facture;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Mgilet\NotificationBundle\Annotation\Notifiable;
use Mgilet\NotificationBundle\NotifiableInterface;

/**
 * Donation controller.
 *
 */
class donationController extends Controller implements NotifiableInterface
{
    /**
     * Lists all donation entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $donations = $em->getRepository('DonationBundle:donation')->findBy(array(), array('id'=>'DESC'));
        $donations_flash = $em->getRepository('DonationBundle:donation')->findday();

        $user=$this->getUser();



        $paginator=$this->get('knp_paginator');

        $resultat = $paginator->paginate(
            $donations,
            $request->query->getInt('page',1),
            $request->query->getInt('limit',4 )

        );
        if($user)
        {

            if(!($user->isSuperAdmin()))
                return $this->render('donation/index.html.twig', array(
                    'donations' => $resultat,
                    'd_flash' => $donations_flash,
                    'paginator' =>$paginator,
                ));
        }
       /* return $this->render('donation/index.html.twig', array(
            'donations' => $donations,
        ));*/
    }
    public function index2Action()
    {
        $em = $this->getDoctrine()->getManager();

        $donations = $em->getRepository('DonationBundle:donation')->findAll();
        $user=$this->getUser();
        if($user)
        {
            if($user->isSuperAdmin() )

                return $this->render('donation/index2.html.twig', array(
                    'donations' => $donations,
                ));


        }

    }
    public function new2Action(Request $request)
    {
        $donation = new Donation();
        $form = $this->createForm('DonationBundle\Form\donationType', $donation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() ) {
            $em = $this->getDoctrine()->getManager();
            $donation->UploadProfilePicture();
            /* $music = $request->get('musique');
            $dessin = $request->get('Dessin');
            $dev = $request->get('Developpement');
            if ($request->$music) {
                $donation->setCategorie('musique');

            }
*/  $donation->setCategorie($request->get('kled'));
            $donation->setUserid($this->getUser());

            $donation->setDateCr(new \DateTime("now"));
            $em->persist($donation);
            $em->flush();

            return $this->redirectToRoute('donation_show', array('id' => $donation->getId(), 'job'=>$request->get('kled')));
        }

        return $this->render('donation/new2.html.twig', array(
            'donation' => $donation,
            'form' => $form->createView(),
            'job' => ''
        ));
    }
    /**
     * Creates a new donation entity.
     *
     */
    public function newAction(Request $request)
    {
        $donation = new Donation();
        $form = $this->createForm('DonationBundle\Form\donationType', $donation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $donation->UploadProfilePicture();
            $donation->setUserid($this->getUser());
            $donation->setDateCr(new \DateTime("now"));
            $em->persist($donation);
            $em->flush();

            return $this->redirectToRoute('donation_show', array('id' => $donation->getId()));
        }

        return $this->render('donation/new.html.twig', array(
            'donation' => $donation,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a donation entity.
     *
     */
    public function showAction(donation $donation)
    {
        $deleteForm = $this->createDeleteForm($donation);

        return $this->render('donation/show.html.twig', array(
            'donation' => $donation,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing donation entity.
     *
     */
    public function editAction(Request $request, donation $donation)
    {
        $deleteForm = $this->createDeleteForm($donation);
        $editForm = $this->createForm('DonationBundle\Form\donationType', $donation);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $donation->UploadProfilePicture();
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('donation_edit', array('id' => $donation->getId()));
        }

        return $this->render('donation/edit.html.twig', array(
            'donation' => $donation,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    public function edit2Action(Request $request, donation $donation)
    {
        $deleteForm = $this->createDeleteForm($donation);
        $editForm = $this->createForm('DonationBundle\Form\donationType', $donation);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('donation_edit2', array('id' => $donation->getId()));
        }

        return $this->render('donation/edit2.html.twig', array(
            'donation' => $donation,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a donation entity.
     *
     */
    public function deleteAction( $id)
    {
        $em=$this->getDoctrine()->getManager();
        $donation=$em->getRepository("DonationBundle:donation")->find($id);
        $em->remove($donation);
        $em->flush();
        return $this->redirectToRoute('donation_index');




    }
   /* public function delete2Action($id)
    {
        $em=$this->getDoctrine()->getManager();
        $donation=$em->getRepository("BallProjetBundle:Projet")->find($id);
        $form = $this->createDeleteForm($donation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($donation);
            $em->flush();
        }

        return $this->redirectToRoute('donation_index2');
    }*/
    public function delete2Action($id)
    {


        $em=$this->getDoctrine()->getManager();
        $donation=$em->getRepository("DonationBundle:donation")->find($id);
        $em->remove($donation);
        $em->flush();
        return $this->redirectToRoute('donation_index2');
    }

    /**
     * @Route("/send-notification", name="send_notification")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function sendNotification(Request $request)
    {
        $manager = $this->get('mgilet.notification');
        $notif = $manager->createNotification('Hello world !');
        $notif->setMessage('This a notification.');
        $notif->setLink('http://symfony.com/');
        // or the one-line method :
        // $manager->createNotification('Notification subject','Some random text','http://google.fr');

        // you can add a notification to a list of entities
        // the third parameter ``$flush`` allows you to directly flush the entities
        $manager->addNotification(array($this->getUser()), $notif, true);

        return $this->redirectToRoute('donation_new');
    }


    /**
     * Creates a form to delete a donation entity.
     *
     * @param donation $donation The donation entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(donation $donation)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('donation_delete', array('id' => $donation->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }


    public function sendNotificationAction(Request $request)
    {
        $manager = $this->get('mgilet.notification');
        $notif = $manager->createNotification('Hello world !');
        $notif->setMessage('This a notification.');
        $notif->setLink('http://symfony.com/');
        // or the one-line method :
        // $manager->createNotification('Notification subject','Some random text','http://google.fr');

        // you can add a notification to a list of entities
        // the third parameter ``$flush`` allows you to directly flush the entities
        $manager->addNotification(array($this->getUser()), $notif, true);

        return $this->redirectToRoute('donation_index');
    }

}
