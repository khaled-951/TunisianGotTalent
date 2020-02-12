<?php

namespace FOSBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SecurityController extends Controller
{
    public function redirectAction()
    {
        $user=$this->getUser();
        if($user)
        {
            if($user->isSuperAdmin() )
                return $this->render('@FOS/Security/admin.html.twig');
            else if(!($user->isSuperAdmin()))
                return $this->render('@FOS/Security/redirect.html.twig');
        }
        return $this->redirectToRoute('fos_user_security_login');
    }

}
