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
                return $this->redirectToRoute('publication_admin_view');
            else if(!($user->isSuperAdmin()))
                return $this->redirectToRoute('publication_index');
        }
        return $this->redirectToRoute('fos_user_security_login');
    }

}
