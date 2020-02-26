<?php

namespace SponsorsBundle\Controller;

use http\Message;
use SponsorsBundle\Entity\Mail;
use SponsorsBundle\Entity\Sponsor;
use SponsorsBundle\Form\MailType;
use SponsorsBundle\Form\SearchMailType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


class MailController extends Controller
{
    public function inboxAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user=$this->getUser();
        if($user != null && $user->isSuperAdmin())

            {
                $mail = new Mail();

                $form=$this->createForm(SearchMailType::class, $mail);
                $form=$form->handleRequest($request);
                $subject= $mail->getSubject();


                if($request->isMethod("POST"))
                {
                   // return new Response('this is the value of input'.$subject);
                    $mails = $em->getRepository('SponsorsBundle:Mail')-> findMailsQB($user->getId(), $subject);
                    $paginator= $this->get('knp_paginator');
                    $res =$paginator->paginate(
                        $mails,
                        $request->query->getInt('page', 1),
                        $request->query->getInt('limit', 5)

                    );
                    return $this->render('@Sponsors/Mail/admin_inbox.html.twig', array('form'=>$form->createView(),'mails'=>$res));


                }
                else
                {
                    $mails = $em->getRepository('SponsorsBundle:Mail')->findUserMailsQB($user->getId());

                    $paginator= $this->get('knp_paginator');
                    $res =$paginator->paginate(
                        $mails,
                        $request->query->getInt('page', 1),
                        $request->query->getInt('limit', 5)

                    );
                    return $this->render('@Sponsors/Mail/admin_inbox.html.twig', array('form'=>$form->createView(),'mails'=>$res));

                }

            }


        else
            {
                return $this->render('@Sponsors/Sponsor/error500.html.twig');

            }
    }



    public function sendAction( Request  $request, $idsp)
    {
        //to fix
        $mail = new Mail();
        $em = $this->getDoctrine()->getManager();
        $sponsor = $em->getRepository('SponsorsBundle:Sponsor')->find($idsp);
        $mail->setMailto($sponsor->getEmail());

        $user= $this->getUser();

        $form = $this->createForm(MailType::class,$mail);
        $form->handleRequest($request);
        if($user != null && $user->isSuperAdmin())
        {
            if($form->isSubmitted() && $form->isValid()){
                $subject= $mail->getSubject();
                $mailto= $mail->getMailto();
                $object = $mail->getObject();
                $username='rawia.khchini@esprit.tn';
                $message=  \Swift_Message::newInstance()
                    ->setSubject($subject)
                    ->setFrom($username)
                    ->setTo($mailto)
                    ->setBody($object,'text/html');
                $this->get('mailer')->send($message);


                $mail->setMailfrom($username);
                $mail->setTime(new \DateTime());
                $mail->setIdsp($sponsor);
                $mail->setIdu($user);
                $em->persist($mail);
                $em->flush();

                $mails = $em->getRepository('SponsorsBundle:Mail')->findAll();
                $paginator= $this->get('knp_paginator');
                $res =$paginator->paginate(
                    $mails,
                    $request->query->getInt('page', 1),
                    $request->query->getInt('limit', 5)

                );
                return $this->redirectToRoute('admin_inbox',array('mails'=>$res));
               // return $this->render('@Sponsors/Mail/admin_inbox.html.twig', array('mails'=>$res));


            }
            return $this->render('@Sponsors/Mail/send.html.twig', array('form'=>$form->createView()));

        }
        else

            return $this->render('@Sponsors/Sponsor/error500.html.twig');

    }

    public function showAction( Request  $request, $id)
    {

        $em = $this->getDoctrine()->getManager();
        $mail = $em->getRepository('SponsorsBundle:Mail')->find($id);

        $user=$this->getUser();
        if($user)
        {
            if($user->isSuperAdmin() )
                return $this->render('@Sponsors/Mail/show.html.twig', array('mail'=>$mail));

            else

                return $this->render('@Sponsors/Sponsor/error500.html.twig');
        }
    }


    public function composeAction( Request  $request)
    {
        $mail = new Mail();
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(MailType::class,$mail);
        $form->handleRequest($request);
        $user =$this->getUser();
        if($user != null && $user->isSuperAdmin()){
           if($form->isSubmitted() && $form->isValid()){
            $subject= $mail->getSubject();
            $mailto= $mail->getMailto();
            $object = $mail->getObject();
            $username='rawia.khchini@esprit.tn';
            $message=  \Swift_Message::newInstance()
                ->setSubject($subject)
                ->setFrom($username)
                ->setTo($mailto)
                ->setBody($object,'text/html');

          //  $message->attach(Swift_Attachment::fromPath('full-path-with-attachment-name'));
            $this->get('mailer')->send($message);


            $mail->setIdu($user);
            $mail->setMailfrom($username);
            $mail->setTime(new \DateTime());


            $em->persist($mail);
            $em->flush();

            $mails = $em->getRepository('SponsorsBundle:Mail')->findAll();
               $paginator= $this->get('knp_paginator');
               $res =$paginator->paginate(
                   $mails,
                   $request->query->getInt('page', 1),
                   $request->query->getInt('limit', 5)

               );
               return $this->redirectToRoute('admin_inbox',array('mails'=>$res));

        }

            return $this->render('@Sponsors/Mail/compose.html.twig', array('form'=>$form->createView()));

        }
        else

            return $this->render('@Sponsors/Sponsor/error500.html.twig');

    }



    public function user_inboxAction(Request $request)
    {


       $em = $this->getDoctrine()->getManager();
        $user=$this->getUser();

        $mail = new Mail();

        $form=$this->createForm(SearchMailType::class, $mail);
        $form=$form->handleRequest($request);
        $subject= $mail->getSubject();


        if($request->isMethod("POST"))
        {
            // return new Response('this is the value of input'.$subject);
            $mails = $em->getRepository('SponsorsBundle:Mail')-> findMailsQB($user->getId(), $subject);
            $paginator= $this->get('knp_paginator');
            $res =$paginator->paginate(
                $mails,
                $request->query->getInt('page', 1),
                $request->query->getInt('limit', 5)

            );
            return $this->render('@Sponsors/Mail/user_inbox.html.twig', array('form'=>$form->createView(),'mails'=>$res));

        }
        else
        {
            $mails = $em->getRepository('SponsorsBundle:Mail')->findUserMailsQB($user->getId());

            $paginator= $this->get('knp_paginator');
            $res =$paginator->paginate(
                $mails,
                $request->query->getInt('page', 1),
                $request->query->getInt('limit', 5)

            );
            return $this->render('@Sponsors/Mail/user_inbox.html.twig', array('form'=>$form->createView(),'mails'=>$res));

        }



    }

    public function user_sendAction( Request  $request, $idsp)
    {
        //to fix
        $mail = new Mail();
        $em = $this->getDoctrine()->getManager();
        $sponsor = $em->getRepository('SponsorsBundle:Sponsor')->find($idsp);
        $mail->setMailto($sponsor->getEmail());

        $user= $this->getUser();

        $form = $this->createForm(MailType::class,$mail);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $subject= $mail->getSubject();
            $mailto= $mail->getMailto();
            $object = $mail->getObject();
            $username='rawia.khchini@esprit.tn';
            $message=  \Swift_Message::newInstance()
                ->setSubject($subject)
                ->setFrom($username)
                ->setTo($mailto)
                ->setBody($object,'text/html');
            $this->get('mailer')->send($message);


            $mail->setMailfrom($username);
            $mail->setTime(new \DateTime());
            $mail->setIdsp($sponsor);
            $mail->setIdu($user);
            $em->persist($mail);
            $em->flush();

            $mails = $em->getRepository('SponsorsBundle:Mail')->findAll();
            $paginator= $this->get('knp_paginator');
            $res =$paginator->paginate(
                $mails,
                $request->query->getInt('page', 1),
                $request->query->getInt('limit', 5)

            );
            return $this->redirectToRoute('user_inbox',array('mails'=>$res));


        }


        return $this->render('@Sponsors/Mail/user_send.html.twig', array('form'=>$form->createView(),'sp'=>$sponsor));
    }

    public function user_showAction( Request  $request, $id)
    {

        $em = $this->getDoctrine()->getManager();
        $mail = $em->getRepository('SponsorsBundle:Mail')->find($id);

        return $this->render('@Sponsors/Mail/user_show.html.twig', array('mail'=>$mail));
    }
}
