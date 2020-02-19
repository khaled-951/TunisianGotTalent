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
                return $this->redirectToRoute('afficherevenementAdmin');
            else if(!($user->isSuperAdmin()))
            {
                if ($user->getTypec()=='chasseur')
                    return $this->redirectToRoute('ajouter');
                else if ($user->getTypec()=='talent')
                {
                    return $this->redirectToRoute('afficheruser');
                }
            }

        }
        return $this->redirectToRoute('fos_user_security_login');
    }

}
