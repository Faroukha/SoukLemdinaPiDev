<?php

namespace EvenementBundle\Controller;

use EvenementBundle\Entity\Event;
use MainBundle\Entity\Notification;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Entity\User;

class DefaultController extends Controller
{
    public function indexAction()
    {

        $em=$this->getDoctrine()->getManager();
        $notif = $em->getRepository(Notification::class)->findAll();

        $user = $em->getRepository(User::class)->findAll();
        $event= $em->getRepository(Event::class)->findAll();

        return $this->render('EvenementBundle:Default:events.html.twig', ['events'=> $event, 'users'=>$user, 'notifs'=>$notif]);
    }

    public function addAction(Request $request){

        $user=$this->getUser();
        $event = new Event();
        $form = $this->createForm('EvenementBundle\Form\EventType', $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $file = $event->getPhoto();

            $fileName = md5(uniqid('', true)).'.'.$file->guessExtension();
            $path = "C:/wamp64/www/pidev" ;
            $file->move(
                $path,
                $fileName
            );
            $em = $this->getDoctrine()->getManager();
            $event->setCreatedAt(new \DateTime());
            $event->setLatitude(15.21576);
            $event->setLongitude(38.65987);
            $event->setUser($user);
            $event->setPhoto($fileName);
            $em->persist($event);
            $em->flush();
            return $this->render('EvenementBundle:Default:events.html.twig');
           // return $this->redirectToRoute('e_show', array('id' => $event->getId()));
        }

        return $this->render('EvenementBundle:Default:addevent.html.twig', array(
            'event' => $event,
            'form' => $form->createView(),
        ));
       // return $this->render('EvenementBundle:Default:events.html.twig');
    }

    public function participerAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $notif = $em->getRepository(Notification::class)->findAll();
        $user = $em->getRepository(User::class)->findAll();
        $event = $em->getRepository(Event::class)->findAll();
        $eventss = $em->getRepository(Event::class)->find($request->get('idEvent'));
        if ($eventss->getNbMax() > 0) {
            $eventss->setNbMax($eventss->getNbMax() - 1);
            $em->persist($eventss);
            $em->flush();
            $str= "oui";
            return $this->render("EvenementBundle:Default:events.html.twig", ['notifs' => $notif, 'events' => $event, 'users' => $user, 'strs'=>null]);
        }else{
            $em = $this->getDoctrine()->getManager();
            $notif = $em->getRepository(Notification::class)->findAll();
            $user = $em->getRepository(User::class)->findAll();
            $event = $em->getRepository(Event::class)->findAll();
            $str = "Désolé nombre de places insufissant";
            return $this->render("EvenementBundle:Default:events.html.twig", ['notifs' => $notif, 'events' => $event, 'users' => $user, 'strs'=>$str]);
        }
    }
}
