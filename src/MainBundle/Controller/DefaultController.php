<?php

namespace MainBundle\Controller;

use MainBundle\Entity\Notification;
use MainBundle\Entity\Produit;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class DefaultController extends Controller
{
    public function indexAction()
    {
        $em=$this->getDoctrine()->getManager();
        $notif = $em->getRepository(Notification::class)->findAll();
        return $this->render('MainBundle:Default:index.html.twig',['notifs'=>$notif]);
    }
    public function contactAction()
    {
        $em=$this->getDoctrine()->getManager();
        $notif = $em->getRepository(Notification::class)->findAll();
        return $this->render('MainBundle:Default:contact.html.twig', ['notifs'=>$notif]);
    }
    public function aboutAction()
    {
        $em=$this->getDoctrine()->getManager();
        $notif = $em->getRepository(Notification::class)->findAll();
        return $this->render('MainBundle:Default:about.html.twig', ['notifs'=>$notif]);
    }

    public function SendMessageContactAction()
    {

    }



}
