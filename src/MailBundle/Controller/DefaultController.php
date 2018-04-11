<?php

namespace MailBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MailBundle\Entity\Mail;
use MailBundle\Form\MailType;
use Symfony\Component\HttpFoundation\Request;
use Swift_Message;
use Symfony\Component\HttpFoundation\Response;
use UserBundle\Entity\User;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        $mail = new Mail();
        $form = $this->createForm(MailType::class, $mail);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $message = \Swift_Message::newInstance()
                ->setSubject('Accusé de réception')
                ->setFrom('espritplus2017@gmail.com')
                ->setTo($mail->getEmail())
                ->setBody(
                    $this->renderView(
                        'MailBundle:Default:email.html.twig',

                        array('nom' => $mail->getNom(), 'prenom'=>$mail->getPrenom())

                    ),
                    'text/html'

                );
            $this->get('mailer')->send($message);
            return $this->redirect($this->generateUrl('my_app_mail_accuse'));
        }
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->findAll();
        return $this->render('MailBundle:Default:index.html.twig',
            array('form' => $form->createView()));
    }

    public function successAction()
    {
        return new Response("email envoyé avec succès, Merci de vérifier votre boite mail.");
    }
}
