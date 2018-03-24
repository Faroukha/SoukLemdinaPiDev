<?php

namespace BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function blogAction()
    {
        return $this->render('BlogBundle:Default:blog.html.twig');
    }
    public function blogDetailAction()
    {
        return $this->render('BlogBundle:Default:blogDetail.html.twig');
    }
}
