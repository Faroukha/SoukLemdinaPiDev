<?php

namespace ApiBundle\Controller;


use MainBundle\Entity\Abonnement;
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
//        $message = new Message();
//        $message->setContenu($request->get('contenu'));
//        $message->setIdEnv($request->get('idEnv'));
//        $message->setIdRes($request->get('idRes'));
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
        $user = $this->getDoctrine()->getManager()->getRepository(User::class)->find($request->get('id'));
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($user);
        return new JsonResponse($formatted);
    }


    public function AllComentsAction()
    {
        $produit = $this->getDoctrine()->getManager()->getRepository(Commentaire::class)->findAll();
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

    public function isAboAction(Request $request)
    {


        $abonnement = $this->getDoctrine()->getRepository(Abonnement::class)->findAll();
        foreach ($abonnement as $abo) {


            if (($abo->getIdmembre()->getId() == $request->get('idM')) && ($abo->getIdartisan()->getId() == $request->get('idA'))) {
                $serializer = new Serializer([new ObjectNormalizer()]);
                $formatted = $serializer->normalize($abo);
                return new JsonResponse($formatted);

            }
        }
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize(false);
        return new JsonResponse($formatted);
    }


    public function getAboByMemberAction(Request $request)
    {


        $abo = $this->getDoctrine()->getRepository(Abonnement::class)->findBy(array('idmembre' => $request->get('idM')));


                $serializer = new Serializer([new ObjectNormalizer()]);
                $formatted = $serializer->normalize($abo);
                return new JsonResponse($formatted);


    }


    public function addAboAction(Request $request){
        $str = $request->get('idartisan');
        $abon = new Abonnement();
        $user1 = $this->getDoctrine()->getRepository(User::class)->find($str);


        $abon->setIdartisan($user1);


        $str1=$request->get('idmembre');
        $user2 = $this->getDoctrine()->getRepository(User::class)->find($str1);
        $abon->setIdmembre($user2);

        $em = $this->getDoctrine()->getManager();
        $em->persist($abon);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($abon);
        return new JsonResponse($formatted);

    }

    public function desaboAction(Request $request)
    {
        $str = $request->get('ida');
        $user1 = $this->getDoctrine()->getRepository(User::class)->find($str);

        $str1 = $request->get('idm');
        $user2 = $this->getDoctrine()->getRepository(User::class)->find($str1);


        $abonnement = $this->getDoctrine()->getRepository(Abonnement::class)->findAll();
        foreach ($abonnement as $abo) {


            if (($abo->getIdmembre() == $user2) && ($abo->getIdartisan() == $user1)) {

                $a = new Abonnement();

                $em = $this->getDoctrine()->getManager();
                $a = $em->getRepository(Abonnement::class)->find($abo->getId());
                // var_dump($a);
                $em->remove($a);
                $em->flush();

            }
        }
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($abonnement);
        return new JsonResponse($formatted);
    }
        public function mapAction(Request $request){
        $originLat = $request->get('originLat');
        $originLng = $request->get('originLng');
        $destinationLat = $request->get('destinationLat');
        $destinationLng= $request->get('destinationLng');
        return $this->render('ApiBundle:Default:MapsView.html.twig', ['originLat'=>$originLat, 'originLng'=>$originLng, 'destinationLat'=>$destinationLat, 'destinationLng'=>$destinationLng]);
    }




//    public function artisansProductAction(){
//        $produit = $this->getDoctrine()->getManager()->getRepository(Produit::class)->findBy([]);
//        $serializer = new Serializer([new ObjectNormalizer()]);
//        $formatted = $serializer->normalize($produit);
//        return new JsonResponse($formatted);
//    }
}
