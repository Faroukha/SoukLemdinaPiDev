<?php

namespace ApiBundle\Controller;

use MainBundle\Entity\Commentaire;
use MainBundle\Entity\Produit;
use MainBundle\Entity\Commande;
use MainBundle\Entity\Panier;
use MainBundle\Entity\Promotion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use UserBundle\Entity\User;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('ApiBundle:Default:index.html.twig');
    }

    public function AllProductsAction(){
      $produit = $this->getDoctrine()->getManager()->getRepository(Produit::class)->findAll();
      $serializer = new Serializer([new ObjectNormalizer()]);
      $formatted = $serializer->normalize($produit);
      return new JsonResponse($formatted);
    }


    public function AllPromotionsAction(){
        $produit = $this->getDoctrine()->getManager()->getRepository(Promotion::class)->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($produit);
        return new JsonResponse($formatted);
    }

    public function AllUsersAction(){
        $produit = $this->getDoctrine()->getManager()->getRepository(User::class)->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($produit);
        return new JsonResponse($formatted);
    }

    public function AllComentsAction(){
        $produit = $this->getDoctrine()->getManager()->getRepository(Commentaire::class)->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($produit);
        return new JsonResponse($formatted);
    }


    public function ValiderpanierAction(Request $request){

        $em=$this->getDoctrine()->getManager();
        $panier = new Panier();
        $panier->setIduser($request->get('idUser')) ;
        $panier->setPrixtotal($request->get('prixTotal'));

        $em->persist($panier);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($panier);
        return new JsonResponse($formatted);

    }
    public function CommanderAction(Request $request){

        $em=$this->getDoctrine()->getManager();
        $commande = new Commande();
        $commande->setIduser($request->get('idUser')) ;
        $commande->setEtat(0);
        $commande->setDate(new \DateTime('now'));
        $commande->setIdpanier($request->get('idPanier'));

        $em->persist($commande);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($commande);
        return new JsonResponse($formatted);


    }

//    public function artisansProductAction(){
//        $produit = $this->getDoctrine()->getManager()->getRepository(Produit::class)->findBy([]);
//        $serializer = new Serializer([new ObjectNormalizer()]);
//        $formatted = $serializer->normalize($produit);
//        return new JsonResponse($formatted);
//    }
}
