<?php
/**
 * Created by PhpStorm.
 * User: jskka
 * Date: 26/03/2018
 * Time: 00:46
 */

namespace ProduitBundle\Controller;
use MainBundle\Entity\Produit;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ProduitController extends Controller
{


    public function AjouterProduitAction(Request $request)
    {

        $produit = new Produit();
        if ($request->isMethod('POST')) {

            $produit->setCategorie($request->get('categorie')) ;
            $produit->setTitre($request->get('titre'));
            $produit->setDescription($request->get('description'));
            $produit->setPrix($request->get('prix'));
            $produit->setQuantite($request->get('quantite'));
            $produit->setImage($request->get('image'));
            $em = $this->getDoctrine()->getManager();
            $em->persist($produit);
            $em->flush();
        }
        return $this->render('ProduitBundle:Produit:ajouter.html.twig', array());

    }


}