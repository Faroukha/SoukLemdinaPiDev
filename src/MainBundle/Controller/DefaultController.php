<?php

namespace MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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
}
