<?php

namespace UserBundle\Controller;

use MainBundle\Entity\Produit;
use UserBundle\Entity\User;
use MainBundle\Entity\Promotion;
use MainBundle\Entity\Pubg;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\BrowserKit\Response;

class DefaultController extends Controller
{
    public function indexAction()
    {

        $user = $this->getUser();

        $em = $this->getDoctrine()->getManager();
        $produit= $em->getRepository(Produit::class)->findAll();

     
        $users = $em->getRepository(User::class)->findAll();

        $promotion=$this->getDoctrine()->getRepository(Promotion::class)->findAll();
        $Pubs = $em->getRepository(Pubg::class)->findAll();

        if ($user) {


            if ($user->hasRole("ROLE_ADMIN")){
                return $this->render('AdminBundle::admin.html.twig');
            }else{


                return $this->render('MainBundle:Default:index.html.twig', [ 'produits' => $produit,'user' => $user,'produitp'=> $promotion,'users' => $users,'Pubs' => $Pubs]);
            }


            //return $this->render('@User/layout.html.twig', ['user' => $user]);
        }


        return $this->render('MainBundle:Default:index.html.twig', [ 'produits' => $produit,'user' => null,'produitp'=> $promotion,'users' => $users,'Pubs' => $Pubs]);

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

        return $this->redirectToRoute('fos_user_security_login');    }


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
