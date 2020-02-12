<?php

namespace SponsorsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('SponsorsBundle:Default:index.html.twig');
    }
}
