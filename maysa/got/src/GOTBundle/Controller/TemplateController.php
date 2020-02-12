<?php

namespace GOTBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TemplateController extends Controller
{
    public function talentprofileAction()
    {
        return $this->render('@GOT/Templates/talentProfile.html.twig');
    }
    public function myprofileAction()
    {
        return $this->render('@GOT/Templates/myProfile.html.twig');
    }
    public function sponsorsAction()
    {
        return $this->render('@GOT/Templates/sponsors.html.twig');
    }
    public function signupAction()
    {
        return $this->render('@GOT/Templates/signup.html.twig');
    }
    public function guestAction()
    {
        return $this->render('@GOT/Templates/guest.html.twig');
    }
    public function dashboardAction()
    {
        return $this->render('@GOT/Dashboard/dashboard.html.twig');
    }
}
