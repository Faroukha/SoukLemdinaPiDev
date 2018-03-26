<?php

namespace UserBundle\Controller;

use MainBundle\Entity\Produit;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\BrowserKit\Response;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $user = $this->getUser();
        $em=$this->getDoctrine()->getRepository(Produit::class);
        $produits=$em->findAll();
        if ($user) {


            if ($user->hasRole("ROLE_ADMIN")){
                //return $this->render('UserBundle::admin.html.twig');
            }else{
                return $this->render('MainBundle:Default:index.html.twig', [ 'produits' => $produits,'user' => $user]);
            }


            //return $this->render('@User/layout.html.twig', ['user' => $user]);
        }

        return $this->render('MainBundle:Default:index.html.twig', [ 'produits' => $produits,'user' => null]);
    }
    public function ishowAction()
    {
        $user = $this->getUser();

        if ($user) {


            if ($user->hasRole("ROLE_ARTISAN")){
                $em=$this->getDoctrine()->getRepository(Produit::class);
                $produits=$em->findByIdartisan($user->getId());
                return $this->render('@FOSUser/Profile/show.html.twig', [ 'produits' => $produits,'user' => $user]);
            }else{
                return $this->render('@FOSUser/Profile/show.html.twig', [ 'produits' => null,'user' => $user]);
            }


            //return $this->render('@User/layout.html.twig', ['user' => $user]);
        }

        return $this->redirectToRoute('fos_user_security_login');    }
}
