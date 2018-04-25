<?php

namespace ApiBundle\Controller;


use MainBundle\Entity\Commentaire;
use MainBundle\Entity\Message;
use MainBundle\Entity\Produit;
use MainBundle\Entity\Promotion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
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

    public function AllMessageUserAction($id){

        $message = $this->getDoctrine()->getManager()->getRepository(Message::class)->find($id);
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($message);
        return new JsonResponse($formatted);
    }

    public function AllMessageAction(){
        $produit = $this->getDoctrine()->getManager()->getRepository(Message::class)->findAll();
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

    public function loginAction (Request $request) {
        $em=$this->getDoctrine()->getManager();
        $user=$em->getRepository(User::class)->findOneBy(['email' =>$request->get('email')]);
        if($user){
            $factory = $this->get('security.encoder_factory');
            $encoder = $factory->getEncoder($user);
            $salt = $user->getSalt();

            if($encoder->isPasswordValid($user->getPassword(),$request->get('password'), $salt)){
                $serializer=new Serializer([new ObjectNormalizer()]);
                $formatted=$serializer->normalize($user);
                return new JsonResponse($formatted);
            }
        }
        return new JsonResponse("Failed");
    }



    public function AddProductAction(Request $request){

            $em=$this->getDoctrine()->getManager();
            $produit = new Produit();
            $produit->setIdartisan($request->get('idartisan')) ;

            $produit->setQuantite($request->get('quantite')) ;
            $produit->setPrix($request->get('prix')) ;
            $produit->setImage($request->get('image')) ;
            $produit->setDescription($request->get('description')) ;
            $produit->setCategorie($request->get('categorie')) ;
            $produit->setTitre($request->get('titre')) ;
            $em->persist($produit);
            $em->flush();
            $serializer = new Serializer([new ObjectNormalizer()]);
            $formatted = $serializer->normalize($produit);
            return new JsonResponse($formatted);


        }

        public function GetUserByIdAction(Request $request){
            $user=$this->getDoctrine()->getManager()->getRepository(User::class)->findOneBy(['id' =>$request->get('id')]);
            $serializer=new Serializer([new ObjectNormalizer()]);
                $formatted=$serializer->normalize($user);
                return new JsonResponse($formatted);
        }




//    public function artisansProductAction(){
//        $produit = $this->getDoctrine()->getManager()->getRepository(Produit::class)->findBy([]);
//        $serializer = new Serializer([new ObjectNormalizer()]);
//        $formatted = $serializer->normalize($produit);
//        return new JsonResponse($formatted);
//    }
}
