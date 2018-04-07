<?php

namespace MainBundle\Controller;

use MainBundle\Entity\Contact;
use MainBundle\Entity\Notification;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;


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

        $notif = $em->getRepository(Notification::class)->findAll();

        $em->persist($contact);
        $em->flush();

        return $this->redirectToRoute('main_homepage', ['notifs'=>$notif]);
    }

}
