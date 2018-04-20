<?php

namespace ApiBundle\Controller;

use MainBundle\Entity\Commentaire;
use MainBundle\Entity\Produit;
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

//    public function artisansProductAction(){
//        $produit = $this->getDoctrine()->getManager()->getRepository(Produit::class)->findBy([]);
//        $serializer = new Serializer([new ObjectNormalizer()]);
//        $formatted = $serializer->normalize($produit);
//        return new JsonResponse($formatted);
//    }
}
