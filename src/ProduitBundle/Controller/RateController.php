<?php
/**
 * Created by PhpStorm.
 * User: jskka
 * Date: 09/04/2018
 * Time: 19:23
 */

namespace ProduitBundle\Controller;

use MainBundle\Entity\Commentaire;
use MainBundle\Entity\Notification;
use MainBundle\Entity\Produit;
use MainBundle\Entity\Rate;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Entity\User;


class RateController extends Controller
{
    public function addAction(Request $request)
    {
        $rate= new Rate();

        $rate->setValue($request->get('value'));
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->find($request->get('idUser'));
        $produit = $em->getRepository(Produit::class)->find($request->get('id'));
        $commentaire = $em->getRepository(Commentaire::class);
        $notif = $em->getRepository(Notification::class)->findAll();

        $rate->setIduser($request->get('idUser'));
        $rate->setIdproduit($request->get('id'));

        $em->persist($rate);
        $em->flush();
        $rates = $em->getRepository(Rate::class)->findAll();

        return $this->render('ProduitBundle:Produit:product-details.html.twig', ['commentaire'=>$commentaire,'rate' => $rates,'produit'=>$produit,'notifs'=>$notif]);

    }



}