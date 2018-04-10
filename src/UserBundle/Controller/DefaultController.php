<?php

namespace UserBundle\Controller;

use MainBundle\Entity\Abonnement;
use MainBundle\Entity\Panier;
use MainBundle\Entity\Notification;
use MainBundle\Entity\Produit;
use MainBundle\Entity\Pubg;
use MainBundle\Entity\Rate;
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
        $notif = $em->getRepository(Notification::class)->findAll();
        $abonnement = $em->getRepository(Abonnement::class)->findAll();
        $produit = $em->getRepository(Produit::class)->findAll();
        $users = $em->getRepository(User::class)->findAll();
        $promotion = $this->getDoctrine()->getRepository(Promotion::class)->findAll();
        $Pubs = $em->getRepository(Pubg::class)->findAll();
        $rates = $em->getRepository(Rate::class)->findAll();

        $paginator = $this->get('knp_paginator');
        $produit = $paginator->paginate(
            $produit,
            $request->query->getInt('page', 1)/*page number*/,
            $request->query->getInt('limit', 9)/*limit per page*/
        );


        if ($user) {


            if ($user->hasRole("ROLE_ADMIN")) {
                return $this->render('AdminBundle::admin.html.twig', ['produits' => $produit]);
            } else {
                return $this->render('MainBundle:Default:index.html.twig', ['rates' => $rates ,'produits' => $produit, 'user' => $user, 'produitp' => $promotion, 'Pubs' => $Pubs, 'users' => $users, 'notifs' => $notif, 'abos', $abonnement]);
            }


            //return $this->render('@User/layout.html.twig', ['user' => $user]);
        }

        return $this->render('MainBundle:Default:index.html.twig', ['produits' => $produit, 'user' => null, 'produitp' => $promotion, 'users' => $users, 'Pubs' => $Pubs, 'notifs' => null]);
    }

    public function ishowAction()
    {
        $user = $this->getUser();
        $em=$this->getDoctrine()->getManager();
        $abonnement = $em->getRepository(Abonnement::class)->findAll();
        if ($user) {


            if ($user->hasRole("ROLE_ARTISAN")) {
                $em = $this->getDoctrine()->getRepository(Produit::class);
                $produits = $em->findByIdartisan($user->getId());
                return $this->render('@FOSUser/Profile/show.html.twig', ['produits' => $produits, 'user' => $user, 'abos'=>$abonnement]);
            } else {
                return $this->render('@FOSUser/Profile/show.html.twig', ['produits' => null, 'user' => $user,'abos'=>$abonnement]);
            }


            //return $this->render('@User/layout.html.twig', ['user' => $user]);
        }

        return $this->redirectToRoute('fos_user_security_login');
    }


    public function showOtherProfilAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $abonnement = $em->getRepository(Abonnement::class)->findAll();
        $userr = $this->getUser();
        $user = $this->getDoctrine()->getRepository(User::class)->find($request->get('id'));
        $bool = $this->isAboAction($userr->getId(), $request->get('id'));
        //return new Response($request->get('id'));
        if ($user->hasRole("ROLE_ARTISAN")) {
            $em = $this->getDoctrine()->getRepository(Produit::class);
            $produits = $em->findByIdartisan($user->getId());


            return $this->render('@FOSUser/Profile/show.html.twig', ['produits' => $produits, 'user' => $user, 'bool' => $bool, 'abos' => $abonnement]);
        } else {
            return $this->render('@FOSUser/Profile/show.html.twig', ['produits' => null, 'user' => $user, 'bool' => $bool, 'abos' => $abonnement]);
        }
    }



    public function aboAction(Request $request)

    {

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

        $userr = $this->getUser();
        $user = $this->getDoctrine()->getRepository(User::class)->find($request->get('idartisan'));
        $bool = $this->isAboAction($userr->getId(), $request->get('id'));
        //return new Response($request->get('id'));
        if ($user->hasRole("ROLE_ARTISAN")) {
            $em = $this->getDoctrine()->getRepository(Produit::class);
            $produits = $em->findByIdartisan($user->getId());
            $em3=$this->getDoctrine()->getManager();
            $abonnement = $em3->getRepository(Abonnement::class)->findAll();


           //return $this->redirectToRoute('main_homepage');
           return $this->render('@FOSUser/Profile/show.html.twig', ['produits' => $produits, 'user' => $user, 'bool' => true, 'abos'=>$abonnement]);
        } else {
            $em3=$this->getDoctrine()->getManager();
            $abonnement = $em3->getRepository(Abonnement::class)->findAll();
           // return $this->redirectToRoute('main_homepage');

            return $this->render('@FOSUser/Profile/show.html.twig', ['produits' => null, 'user' => $user, 'bool' => $bool , 'abos'=>$abonnement]);
        }


    }
    public function isAboAction($idM, $idA)
    {


        $abonnement = $this->getDoctrine()->getRepository(Abonnement::class)->findAll();
        foreach ($abonnement as $abo) {


            if (($abo->getIdmembre()->getId() == $idM) && ($abo->getIdartisan()->getId() == $idA)) {
                return true;
            }
        }
        return false;
    }
    public function desaboAction(Request $request)
    {
        $str = $request->get('idartisan');
        $user1 = $this->getDoctrine()->getRepository(User::class)->find($str);

        $str1=$request->get('idmembre');
        $user2 = $this->getDoctrine()->getRepository(User::class)->find($str1);


        $abonnement = $this->getDoctrine()->getRepository(Abonnement::class)->findAll();
        foreach ($abonnement as $abo) {


            if (($abo->getIdmembre() == $user2) && ($abo->getIdartisan() == $user1)) {

                $a = new Abonnement();

                $em=$this->getDoctrine()->getManager();
                $a= $em->getRepository(Abonnement::class)->find($abo->getId());
               // var_dump($a);
                $em->remove($a);
                $em->flush();

            }
        }

        $userr = $this->getUser();
        $user = $this->getDoctrine()->getRepository(User::class)->find($request->get('idartisan'));
        $bool = $this->isAboAction($userr->getId(), $request->get('idartisan'));
        //return new Response($request->get('id'));
        if ($user->hasRole("ROLE_ARTISAN")) {
            $em = $this->getDoctrine()->getRepository(Produit::class);
            $produits = $em->findByIdartisan($user->getId());
            $em1= $this->getDoctrine()->getManager();
            $abonnement=$em1->getRepository(Abonnement::class)->findAll();


            return $this->render('@FOSUser/Profile/show.html.twig', ['produits' => $produits, 'user' => $user, 'bool' => $bool, 'abos'=>$abonnement]);
        } else {
            return $this->render('@FOSUser/Profile/show.html.twig', ['produits' => null, 'user' => $user, 'bool' => $bool, 'abos'=>$abonnement]);

        }

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

