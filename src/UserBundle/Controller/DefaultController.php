<?php

namespace UserBundle\Controller;

use MainBundle\Entity\Abonnement;
use MainBundle\Entity\Produit;
use MainBundle\Entity\Pubg;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use UserBundle\Entity\User;
use MainBundle\Entity\Promotion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {

        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $produit = $em->getRepository(Produit::class)->findAll();
        $users = $em->getRepository(User::class)->findAll();
        $promotion = $this->getDoctrine()->getRepository(Promotion::class)->findAll();
        $Pubs = $em->getRepository(Pubg::class)->findAll();

        $paginator = $this->get('knp_paginator');
        $produit = $paginator->paginate(
            $produit,
            $request->query->getInt('page', 1)/*page number*/,
            $request->query->getInt('limit', 9)/*limit per page*/
        );


        if ($user) {


            if ($user->hasRole("ROLE_ADMIN")){
                return $this->render('AdminBundle::admin.html.twig', [ 'produits' => $produit]);
            }else{
                return $this->render('MainBundle:Default:index.html.twig', [ 'produits' => $produit,'user' => $user,'produitp'=> $promotion ,'Pubs' => $Pubs, 'users' => $users]);
            }


            //return $this->render('@User/layout.html.twig', ['user' => $user]);
        }

        return $this->render('MainBundle:Default:index.html.twig', ['produits' => $produit, 'user' => null, 'produitp' => $promotion, 'users' => $users,'Pubs' => $Pubs]);
    }

    public function ishowAction()
    {
        $user = $this->getUser();

        if ($user) {


            if ($user->hasRole("ROLE_ARTISAN")){
                $em=$this->getDoctrine()->getRepository(Produit::class);
                $produits=$em->findByIdartisan($user->getId());
                return $this->render('@FOSUser/Profile/show.html.twig', [ 'produits' => $produits,'user' => $user]);
            }else{
                return $this->render('@FOSUser/Profile/show.html.twig', [ 'produits' => null,'user' => $user]);
            }


            //return $this->render('@User/layout.html.twig', ['user' => $user]);
        }

        return $this->redirectToRoute('fos_user_security_login');
    }


    public function showOtherProfilAction(Request $request)
    {
        $userr = $this->getUser();
        $user = $this->getDoctrine()->getRepository(User::class)->find($request->get('id'));
        $bool=$this->isAboAction($userr->getId(),$request->get('id'));
        //return new Response($request->get('id'));
            if ($user->hasRole("ROLE_ARTISAN")) {
                $em = $this->getDoctrine()->getRepository(Produit::class);
                $produits = $em->findByIdartisan($user->getId());


                return $this->render('@FOSUser/Profile/show.html.twig', ['produits' => $produits, 'user' => $user, 'bool'=> $bool] );
            } else {
                return $this->render('@FOSUser/Profile/show.html.twig', ['produits' => null, 'user' => $user, 'bool'=> $bool]);
            }
    }

    public function isAboAction($idM, $idA)
    {

        $abonnement = $this->getDoctrine()->getRepository(Abonnement::class)->findAll();
        foreach ($abonnement as $abo) {


            if (($abo->getIdmembre() == $idM) && ($abo->getIdartisan() == $idA)) {
                return true;
            }
        }
        return false;
    }

    public function aboAction(Request $request)

    {


            $abon = new Abonnement();
            $abon->setIdartisan($request->get('idA'));
            $abon->setIdmembre($request->get('idM'));
            $em=$this->getDoctrine()->getManager();
            $em->persist($abon);
            $em->flush();

        $userr = $this->getUser();
        $user = $this->getDoctrine()->getRepository(User::class)->find($request->get('idA'));
        $bool=$this->isAboAction($userr->getId(),$request->get('id'));
        //return new Response($request->get('id'));
        if ($user->hasRole("ROLE_ARTISAN")) {
            $em = $this->getDoctrine()->getRepository(Produit::class);
            $produits = $em->findByIdartisan($user->getId());


            return $this->render('@FOSUser/Profile/show.html.twig', ['produits' => $produits, 'user' => $user, 'bool'=> $bool] );
        } else {
            return $this->render('@FOSUser/Profile/show.html.twig', ['produits' => null, 'user' => $user, 'bool'=> $bool]);
        }



    }

    public function desaboAction(Request $request)
    {
        $userr = $this->getUser();
        $abonnement = $this->getDoctrine()->getRepository(Abonnement::class)->findAll();
        foreach ($abonnement as $abo) {


            if (($abo->getIdmembre() == $userr->getId()) && ($abo->getIdartisan() == $request->get('idA'))) {
                $a = $this->getDoctrine()->getRepository(Abonnement::class)->find($abo->getId());
                $abonnement -> remove($a);
                $abonnement -> flush();
            }
        }

        $userr = $this->getUser();
        $user = $this->getDoctrine()->getRepository(User::class)->find($request->get('idA'));
        $bool=$this->isAboAction($userr->getId(),$request->get('idA'));
        //return new Response($request->get('id'));
        if ($user->hasRole("ROLE_ARTISAN")) {
            $em = $this->getDoctrine()->getRepository(Produit::class);
            $produits = $em->findByIdartisan($user->getId());


            return $this->render('@FOSUser/Profile/show.html.twig', ['produits' => $produits, 'user' => $user, 'bool'=> $bool] );
        } else {
            return $this->render('@FOSUser/Profile/show.html.twig', ['produits' => null, 'user' => $user, 'bool'=> $bool]);
        }


    }

//    public function AffichierPromotionAction()
//    {
//        $em = $this->getDoctrine()->getManager();
//        $query = $em->createQuery("SELECT
//    p.categorie,p.titre,p.prix,p.image,pp.taux
//FROM
//     produit AS p , promotion AS pp
//JOIN promotion pp ON
//    pp.idProduit = p.id
//WHERE p.id IN (
//SELECT id FROM promotion");
//        $statement = $query->getResult();
//
//        return $this->render('ProduitBundle:Produit:index.html.twig',['produit' => $statement]);
//
//    }
}
