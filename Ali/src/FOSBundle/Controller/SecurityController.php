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
                return $this->redirectToRoute('donation_index2');
            else if(!($user->isSuperAdmin()))
                return $this->redirectToRoute('donation_index');
        }
        return $this->redirectToRoute('fos_user_security_login');
    }

}
