<?php

namespace EvenementBundle\Controller;

use EvenementBundle\Entity\Event;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('EvenementBundle:Default:events.html.twig');
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

            $event->setUser($user);
            $event->setPhoto($fileName);
            $em->persist($event);
            $em->flush();

           // return $this->redirectToRoute('e_show', array('id' => $event->getId()));
        }

        return $this->render('EvenementBundle:Default:addevent.html.twig', array(
            'event' => $event,
            'form' => $form->createView(),
        ));
    }
}
