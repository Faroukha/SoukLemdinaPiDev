<?php

namespace EvenementBundle\Controller;

use blackknight467\StarRatingBundle\Form\RatingType;
use EvenementBundle\Entity\Event;
use EvenementBundle\Entity\Rating;
use MainBundle\Entity\Notification;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Entity\User;

class DefaultController extends Controller
{
    public function indexAction()
    {

        $em = $this->getDoctrine()->getManager();
        $rating = $em->getRepository(Rating::class)->avgrating();
        $notif = $em->getRepository(Notification::class)->findAll();

        $user = $em->getRepository(User::class)->findAll();
        $event = $em->getRepository(Event::class)->findAll();

        return $this->render('EvenementBundle:Default:events.html.twig', ['events' => $event, 'users' => $user, 'notifs' => $notif, 'rating'=>$rating]);
    }

    public function infoAction($id,Request $request){

        $rating = new Rating();
        $m = $this->getDoctrine()->getManager();
        $mark = $m->getRepository(Event::class)->find($id);
        $form = $this->createFormBuilder($rating)
            ->add('rating', RatingType::class, [
                'label' => 'Rating'
            ])
            ->add('valider', SubmitType::class, array(
                'attr' => array(

                    'class' => 'btn btn-xs btn-primary'
                )))
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $rating->setIdE($mark->getId());
            $m->persist($rating);
            $m->flush();
        }

        $data=array(
            'm' => $mark,
            'f' => $form->createView()
        );

        return $this->render('EvenementBundle:Default:info.html.twig',$data);



    }


    public function addAction(Request $request)
    {

        $user = $this->getUser();
        $event = new Event();
        $form = $this->createForm('EvenementBundle\Form\EventType', $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $file = $event->getPhoto();

            $fileName = md5(uniqid('', true)) . '.' . $file->guessExtension();
            $path = "C:/wamp64/www/SouklemdinaPiDev/web/Uploads/images";
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
            $event->setSeat($event->getNbMax());
            $em->persist($event);
            $em->flush();
            $em = $this->getDoctrine()->getManager();
            $notif = $em->getRepository(Notification::class)->findAll();
            $user = $em->getRepository(User::class)->findAll();
            $event = $em->getRepository(Event::class)->findAll();
            $rating = $em->getRepository(Rating::class)->find($request->get('id'));
            return $this->render('EvenementBundle:Default:events.html.twig', ['rating'=>$rating, 'notifs' => $notif, 'users' => $user, 'events' => $event]);
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
            $str = "oui";
            return $this->render("EvenementBundle:Default:events.html.twig", ['notifs' => $notif, 'events' => $event, 'users' => $user, 'strs' => null]);
        } else {
            $em = $this->getDoctrine()->getManager();
            $notif = $em->getRepository(Notification::class)->findAll();
            $user = $em->getRepository(User::class)->findAll();
            $event = $em->getRepository(Event::class)->findAll();
            $str = "Désolé nombre de places insufissant";
            return $this->render("EvenementBundle:Default:events.html.twig", ['notifs' => $notif, 'events' => $event, 'users' => $user, 'strs' => $str]);
        }
    }


}




