<?php
/**
 * Created by PhpStorm.
 * User: jskka
 * Date: 27/03/2018
 * Time: 02:07
 */

namespace ProduitBundle\Controller;


use MainBundle\Entity\Notification;

use MainBundle\Entity\Produit;
use MainBundle\Entity\Promotion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Swift_Message;
use UserBundle\Entity\User;


class PromotionController extends Controller
{
    public function AjouterPromotionAction(Request $request)
    {

        $promotion = new Promotion();

        $promotion->setIdproduit($request->get('idproduit'));
        $promotion->setTaux($request->get('taux'));
        $em = $this->getDoctrine()->getManager();
        $em->persist($promotion);
        $em->flush();
        $produit = new Produit();
        $produit = $em->getRepository(Produit::class)->find($request->get('idproduit'));


        $produit->setPrix($request->get('taux') * $produit->getPrix() / 100);
        $em->persist($produit);
        $em->flush();

        $em = $this->getDoctrine()->getManager();

        $message = \Swift_Message::newInstance()
            ->setSubject('Accusé de réception')
            ->setFrom('fnakai007@gmail.com')
            ->setTo('fourati.karim.karim@gmail.com')
            ->setBody('Votre promotion a ajouter :');
        $this->get('mailer')->send($message);

        $notif = $em->getRepository(Notification::class)->findAll();
        return $this->redirectToRoute('ff');

    }


}