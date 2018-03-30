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
use Symfony\Component\HttpFoundation\Response;

class ProduitController extends Controller
{


    public function AjouterProduitAction(Request $request)
    {

        $produit = new Produit();
        if ($request->isMethod('POST')) {
            $produit->setIdartisan($request-> get('idArtisan'));
            $produit->setCategorie($request->get('categorie')) ;
            $produit->setTitre($request->get('titre'));
            $produit->setDescription($request->get('description'));
            $produit->setPrix($request->get('prix'));
            $produit->setImage($request->get('image'));
            $produit->setQuantite($request->get('quantite'));
            $em = $this->getDoctrine()->getManager();
            $em->persist($produit);
            $em->flush();
        }
        return $this->redirectToRoute('ff');

    }

    public function supprimerProduitAction(Request $request )
    {

        $em=$this->getDoctrine()->getManager();
        $produit=$em->getRepository(Produit::class)->find($request->get("id"));;
        $em->remove($produit);
        $em->flush();
        return $this->redirectToRoute("main_homepage");

    }



}