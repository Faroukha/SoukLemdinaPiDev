<?php

namespace ApiBundle\Controller;


use MainBundle\Entity\Commentaire;
use MainBundle\Entity\Message;
use MainBundle\Entity\Produit;
use MainBundle\Entity\Promotion;
use MainBundle\Entity\Rate;
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

    public function AllProductsAction()
    {
        $produit = $this->getDoctrine()->getManager()->getRepository(Produit::class)->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($produit);
        return new JsonResponse($formatted);
    }

    public function AllProductsArtisanAction($id)
    {
        $produit = $this->getDoctrine()->getManager()->getRepository(Produit::class)->findBy(array("idartisan" => $id));
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($produit);
        return new JsonResponse($formatted);
    }

    public function deletAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $Publicite = $em->getRepository("MainBundle:Produit")->find($id);
        $em->remove($Publicite);
        $em->flush();
        return 0;
    }

    public function AllMessageUserAction($id)
    {

        $message = $this->getDoctrine()->getManager()->getRepository(Message::class)->find($id);
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($message);
        return new JsonResponse($formatted);
    }

    public function AllMessageAction()
    {
        $produit = $this->getDoctrine()->getManager()->getRepository(Message::class)->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($produit);
        return new JsonResponse($formatted);
    }

    public function AllPromotionsAction()
    {
        $promotion = $this->getDoctrine()->getManager()->getRepository(Promotion::class)->findAll();

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($promotion);
        return new JsonResponse($formatted);
    }

    public function AddCommAction($user, $idP, $text)
    {

        $commentaire = New Commentaire();
        $em = $this->getDoctrine()->getManager();
        $commentaire->setText($text);
        $commentaire->setIdproduit($idP);
        $commentaire->setEmailuser($user);
        $em->persist($commentaire);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($commentaire);
        return new JsonResponse("done");

    }

//
//
//    public function supprimerCommentaireAction(Request $request)
//    {
//        $em = $this->getDoctrine()->getManager();
//        $id1 = $request->get('id_commentaire');
//        $id = $request->get('id_user');
//        $commentaire = $em->getRepository(CommentaireR::class);
//        $commentaire1 = $commentaire->findOneBy(array('id' => $id1));
//        // $reponse=$em->getRepository(ReponseC::class)->deletelesreponses($commentaire1);
//        $rubrique = $commentaire1->getIdPublication();
//        $commentaire->deleteCommentaire($id1, $id);
//        $rubrique->setNbcommentaire($rubrique->getNbcommentaire() - 1);
//        $em->persist($rubrique);
//        $em->flush();
//        $serializer = new Serializer([new ObjectNormalizer()]);
//        $formatted = $serializer->normalize($rubrique);
//        return new JsonResponse($formatted);
//    }
    public function AjouterRateAction($idu, $idp, $value)
    {
        $rate = new Rate();
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->find($idu);
        $produit = $em->getRepository(Produit::class)->find($idp);
        $rate->setIduser($user->getId());
        $rate->setIdproduit($produit->getId());
        $rate->setValue($value);
        $em->persist($rate);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($rate);
        return new JsonResponse($formatted);

    }

    public function AllUsersAction()
    {
        $produit = $this->getDoctrine()->getManager()->getRepository(User::class)->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($produit);
        return new JsonResponse($formatted);
    }

    public function AddproduitAction(Request $request, $quantite, $image, $description, $categorie, $titre, $prix, User $idartisan)
    {
        $em = $this->getDoctrine()->getManager();
        $produit = new Produit();
        $user = $em->getRepository("UserBundle:User")->find($idartisan);
        $produit->setIdartisan($user->getId());
        $produit->setQuantite($quantite);
        $produit->setPrix($prix);
        $produit->setImage($image);
        $produit->setDescription($description);
        $produit->setCategorie($categorie);
        $produit->setTitre($titre);
        $encoder = new JsonResponse();
        $nor = new ObjectNormalizer();
        $nor->setCircularReferenceHandler(function ($obj) {
            return $obj->getId();
        });
        $em->persist($produit);
        $em->flush();

        $serializer = new Serializer(array($nor, $encoder));
        $formatted = $serializer->normalize($produit);
        return new JsonResponse($formatted);


    }


    public function AddproduitpromotionAction(Request $request, $taux, $idproduit)
    {
        $em = $this->getDoctrine()->getManager();
        $promotion = new Promotion();
        $promotion->setIdproduit($idproduit);
        $promotion->setTaux($taux);
        $encoder = new JsonResponse();
        $nor = new ObjectNormalizer();
        $nor->setCircularReferenceHandler(function ($obj) {
            return $obj->getId();
        });
        $em->persist($promotion);
        $em->flush();

        $serializer = new Serializer(array($nor, $encoder));
        $formatted = $serializer->normalize($promotion);
        return new JsonResponse($formatted);
    }


    public function GetUserbyIdAction(Request $request)
    {
        $user = $this->getDoctrine()->getRepository(User::class)->find($request->get('id'));
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($user);
        return new JsonResponse($formatted);
    }

    public function HistoryMessagesAction(User $idenv, User $idres)
    {
        $message = $this->getDoctrine()->getRepository(Message::class)->getmsg($idenv, $idres);
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($message);
        return new JsonResponse($formatted);
    }

    public function MesMessagesAction(User $idUser)
    {
        $message = $this->getDoctrine()->getRepository(Message::class)->getmessages($idUser);
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($message);
        return new JsonResponse($formatted);
    }


    public function AllComsAction($idP)
    {
        $produit = $this->getDoctrine()->getManager()->getRepository(Commentaire::class)->findBy(array('idproduit'=>$idP));
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($produit);
        return new JsonResponse($formatted);
    }

//    public function FindUserByIdAction(){
//        $produit = $this->getDoctrine()->getManager()->getRepository(User::class)->find();
//        $serializer = new Serializer([new ObjectNormalizer()]);
//        $formatted = $serializer->normalize($produit);
//        return new JsonResponse($formatted);
//    }

    public function loginAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->findOneBy(['email' => $request->get('email')]);
        if ($user) {
            $factory = $this->get('security.encoder_factory');
            $encoder = $factory->getEncoder($user);
            $salt = $user->getSalt();

            if ($encoder->isPasswordValid($user->getPassword(), $request->get('password'), $salt)) {
                $serializer = new Serializer([new ObjectNormalizer()]);
                $formatted = $serializer->normalize($user);
                return new JsonResponse($formatted);
            }
        }
        return new JsonResponse("Failed");
    }


    public function AddProductAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $produit = new Produit();
        $produit->setIdartisan($request->get('idartisan'));

        $produit->setQuantite($request->get('quantite'));
        $produit->setPrix($request->get('prix'));
        $produit->setImage($request->get('image'));
        $produit->setDescription($request->get('description'));
        $produit->setCategorie($request->get('categorie'));
        $produit->setTitre($request->get('titre'));
        $em->persist($produit);
        $em->flush();
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
