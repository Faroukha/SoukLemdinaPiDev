<?php

namespace MainBundle\Controller;

use MainBundle\Entity\Produit;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('MainBundle:Default:index.html.twig');
    }
    public function contactAction()
    {
        return $this->render('MainBundle:Default:contact.html.twig');
    }
    public function aboutAction()
    {
        return $this->render('MainBundle:Default:about.html.twig');
    }

    public function SendMessageContactAction()
    {

    }


}
