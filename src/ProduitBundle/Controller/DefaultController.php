<?php

namespace ProduitBundle\Controller;

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
        $em=$this->getDoctrine()->getRepository(Produit::class);
        $produit=$em->find($request->get('id'));

        return $this->render('ProduitBundle:Produit:product-details.html.twig',['produit'=>$produit]);
    }
    public function detailscomAction(Request $request)
    {
        $em=$this->getDoctrine()->getRepository(Commentaire::class);
        $commentaire=$em->find($request->get('id'));

        return $this->render('ProduitBundle:Produit:product-details.html.twig',['commentaire'=>$commentaire]);
    }
    public function detailsartisanAction(Request $request)
    {
        $em=$this->getDoctrine()->getRepository(Produit::class);
        $produit=$em->find($request->get('id'));

        return $this->render('ProduitBundle:Produit:produit-details-artisan.html.twig',['produit'=>$produit]);
    }
    public function shopAction()
    {
        return $this->render('ProduitBundle:Produit:shop.html.twig');
    }

    public function cartAction()
    {
        return $this->render('ProduitBundle:Produit:cart.html.twig');
    }

    public function wishlistAction()
    {
        return $this->render('ProduitBundle:Produit:wishlist.html.twig');
    }
    public function detailspromotionAction(Request $request)
    {
        $em=$this->getDoctrine()->getRepository(Produit::class);
        $produit=$em->find($request->get('id'));

        return $this->render('ProduitBundle:Produit:promotion-detailler.html.twig',['produit'=>$produit]);
    }




}

