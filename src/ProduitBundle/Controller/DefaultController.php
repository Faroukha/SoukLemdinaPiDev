<?php

namespace ProduitBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('ProduitBundle:Produit:index.html.twig');
    }

    public function detailsAction()
{
    return $this->render('ProduitBundle:Produit:product-details.html.twig');
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
}

