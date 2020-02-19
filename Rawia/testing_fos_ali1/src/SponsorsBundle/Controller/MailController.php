<?php

namespace SponsorsBundle\Controller;

use SponsorsBundle\Entity\Mail;
use SponsorsBundle\Entity\Sponsor;
use SponsorsBundle\Form\MailType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


class MailController extends Controller
{
    public function inboxAction()
    {
        $em = $this->getDoctrine()->getManager();

        $mails = $em->getRepository('SponsorsBundle:Mail')->findAll();
        return $this->render('@Sponsors/Mail/admin_inbox.html.twig', array('mails'=>$mails));

    }



    public function sendAction( Request  $request, $idsp)
    {
        $mail = new Mail();
        $em = $this->getDoctrine()->getManager();
        $sponsor = $em->getRepository('SponsorsBundle:Sponsor')->find($idsp);
        $mail->setMailto($sponsor->getEmail());

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

            $em->persist($mail);
            $em->flush();

            $mails = $em->getRepository('SponsorsBundle:Mail')->findAll();
            return $this->render('@Sponsors/Mail/admin_inbox.html.twig', array('mails'=>$mails));

        }


        return $this->render('@Sponsors/Mail/send.html.twig', array('form'=>$form->createView()));
    }


    public function composeAction( Request  $request)
    {
        $mail = new Mail();
        $em = $this->getDoctrine()->getManager();

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


            $em->persist($mail);
            $em->flush();

            $mails = $em->getRepository('SponsorsBundle:Mail')->findAll();
            return $this->render('@Sponsors/Mail/admin_inbox.html.twig', array('mails'=>$mails));

        }


        return $this->render('@Sponsors/Mail/send.html.twig', array('form'=>$form->createView()));
    }
}
