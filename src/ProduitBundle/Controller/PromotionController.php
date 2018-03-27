<?php
/**
 * Created by PhpStorm.
 * User: jskka
 * Date: 27/03/2018
 * Time: 02:07
 */

namespace ProduitBundle\Controller;
use MainBundle\Entity\Produit;
use MainBundle\Entity\Promotion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
class PromotionController extends Controller
{
    public function AjouterPromotionAction(Request $request)
    {

        $promotion = new Promotion();

            $promotion->setIdproduit($request-> get('idproduit'));
            $promotion->setTaux($request-> get('taux'));
            $em = $this->getDoctrine()->getManager();
            $em->persist( $promotion);
            $em->flush();
            $produit = new Produit();
            $produit =$em->getRepository(Produit::class)->find($request->get('idproduit'));
            $produit->setPrix($request->get('taux')*$produit->getPrix()/100);
            $em->persist($produit);
            $em->flush();
        return $this->redirectToRoute('ff');

    }





}