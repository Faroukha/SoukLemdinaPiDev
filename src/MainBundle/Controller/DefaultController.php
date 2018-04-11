<?php

namespace MainBundle\Controller;

use MainBundle\Entity\Contact;
use MainBundle\Entity\Notification;
use MainBundle\Entity\Produit;
use MainBundle\Entity\Rate;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Entity\User;


class DefaultController extends Controller
{
    public function indexAction()
    {
        $em=$this->getDoctrine()->getManager();
        $notif = $em->getRepository(Notification::class)->findAll();
        $rates = $em->getRepository(Rate::class)->findAll();
        return $this->render('MainBundle:Default:index.html.twig',['notifs'=>$notif ,'rates'=>$rates]);
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
    public function allreclamationUserAction(Request $request){

        $em = $this->getDoctrine()->getManager();

        $user = $em->getRepository(User::class)->find($request->get('idUser'));
        $notif = $em->getRepository(Notification::class)->findAll();

        $rec = $em ->getRepository(Contact::class)->findAll();


        return $this->render('MainBundle:Default:allreclamationUser.html.twig',['users'=>$user,'recs'=>$rec,'notifs'=>$notif]);

    }


    public function SendMessageContactAction()
    {

    }



}
