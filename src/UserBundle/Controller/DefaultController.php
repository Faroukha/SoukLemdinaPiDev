<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $user = $this->getUser();
        if ($user) {


            if ($user->hasRole("ROLE_ADMIN")){
                //return $this->render('UserBundle::admin.html.twig');
            }else{
                return $this->render('MainBundle:Default:index.html.twig', [ 'user' => $user]);
            }


            //return $this->render('@User/layout.html.twig', ['user' => $user]);
        }

        return $this->render('MainBundle:Default:index.html.twig', [ 'user' => null]);
    }
}
