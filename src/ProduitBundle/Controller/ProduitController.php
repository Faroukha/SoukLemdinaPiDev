<?php
/**
 * Created by PhpStorm.
 * User: jskka
 * Date: 26/03/2018
 * Time: 00:46
 */

namespace ProduitBundle\Controller;
use FOS\UserBundle\Model\UserInterface;
use MainBundle\Entity\Notification;
use MainBundle\Entity\Produit;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use UserBundle\Entity\User;

use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ProduitController extends Controller
{


//    public function AjouterProduitAction(Request $request)
//    {
//
//        $produit = new Produit();
//        if ($request->isMethod('POST')) {
//            $produit->setIdartisan($request-> get('idArtisan'));
//            $produit->setCategorie($request->get('categorie')) ;
//            $produit->setTitre($request->get('titre'));
//            $produit->setDescription($request->get('description'));
//            $produit->setPrix($request->get('prix'));
//            $produit->setImage($request->get('image'));
//            $produit->setQuantite($request->get('quantite'));
//            $em = $this->getDoctrine()->getManager();
//            $em->persist($produit);
//            $em->flush();
//        }
//        return $this->redirectToRoute('ff');
//
//    }

    public function AjouterProduitAction(Request $request )
    {
        $po = new Produit();
        $form = $this->createFormBuilder($po)

            ->add('categorie', TextType::class)
            ->add('titre', TextType::class)
            ->add('description', TextType::class)
            ->add('prix', TextType::class)
            ->add('image', FileType::class, array('label' => 'Image(JPG)'))
            ->add('quantite', TextType::class)
            ->add('save', SubmitType::class, array())
            ->getForm();

        $form->handleRequest($request);
        if ($form->isValid()) {

            $user = $this->getUser();
            $n=new Notification();
            $n->setIdUser($user);
            $n->setMessage($user->getNom()." had added a new product");
            $n->setSubject("subjectccc");
            $n->setSeen(0);
            $n->setLink("hhh");
            $em1= $this->getDoctrine()->getManager();
            $em1->persist($n);
            $em1->flush();
            $po->setIdartisan($user->getId());
            $em = $this->getDoctrine()->getManager();
            $em->persist($po);
            $em->flush();
        }
        return $this->render('ProduitBundle:Produit:ajouter.html.twig',
            ['form' => $form->createView()]);
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