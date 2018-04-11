<?php

namespace MainBundle\Controller;

use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use MainBundle\Entity\Contact;
use MainBundle\Entity\Etat;
use MainBundle\Entity\Notification;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Entity\User;


class ContactController extends Controller
{

    public function addAction(Request $request)
    {

        $contact = new Contact();
        $contact->setEtat(0);
        $contact->setName($request->get('name'));
        $contact->setEmail($request->get('email'));
        $contact->setSubject($request->get('subject'));
        $contact->setMessage($request->get('message'));
        $em = $this->getDoctrine()->getManager();
        $em1 = $this->getDoctrine()->getManager();
        $em2 = $this->getDoctrine()->getManager();
        $user= $em->getRepository(User::class)->find($request->get('idUser'));
        $contact->setIdUser($user);

        $etat = $em1->getRepository(Etat::class)->find(2);
        $etat ->setNbr($etat ->getNbr() +1) ;

        $notif = $em->getRepository(Notification::class)->findAll();

        $em->persist($contact);
        $em->flush();
        $em1->persist($etat);
        $em1->flush();



        return $this->redirectToRoute('main_homepage', ['notifs'=>$notif ,'users' => $user]);

    }


}
