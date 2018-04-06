<?php

namespace ProduitBundle\Controller;

use MainBundle\Entity\Commentaire;
use MainBundle\Entity\Notification;
use MainBundle\Entity\Produit;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('ProduitBundle:Produit:index.html.twig');
    }
    public function ajouterAction()
    {
        return $this->render('ProduitBundle:Produit:ajouter.html.twig');
    }


    public function detailsAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $notif = $em->getRepository(Notification::class)->findAll();
        $em=$this->getDoctrine()->getRepository(Produit::class);
        $es=$this->getDoctrine()->getRepository(Commentaire::class);
        $commentaire=$es->findAll();

        $produit=$em->find($request->get('id'));

        return $this->render('ProduitBundle:Produit:product-details.html.twig',['produit'=>$produit,'commentaire'=>$commentaire, 'notifs'=>$notif]);
    }

    public function detailsartisanAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $notif = $em->getRepository(Notification::class)->findAll();
        $em=$this->getDoctrine()->getRepository(Produit::class);
        $produit=$em->find($request->get('id'));

        return $this->render('ProduitBundle:Produit:produit-details-artisan.html.twig',['produit'=>$produit, 'notifs'=>$notif]);
    }
    public function shopAction()
    {
        $em=$this->getDoctrine()->getManager();
        $notif = $em->getRepository(Notification::class)->findAll();
        return $this->render('ProduitBundle:Produit:shop.html.twig',['notifs'=>$notif]);
    }

    public function cartAction()
    {
        $em=$this->getDoctrine()->getManager();
        $notif = $em->getRepository(Notification::class)->findAll();
        return $this->render('ProduitBundle:Produit:cart.html.twig',['notifs'=>$notif]);
    }

    public function wishlistAction()
    {
        $em=$this->getDoctrine()->getManager();
        $notif = $em->getRepository(Notification::class)->findAll();
        return $this->render('ProduitBundle:Produit:wishlist.html.twig',['notifs'=>$notif]);
    }
    public function detailspromotionAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $notif = $em->getRepository(Notification::class)->findAll();
        $em=$this->getDoctrine()->getRepository(Produit::class);
        $produit=$em->find($request->get('id'));

        return $this->render('ProduitBundle:Produit:promotion-detailler.html.twig',['produit'=>$produit, 'notifs'=>$notif]);
    }




}

