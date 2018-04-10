<?php
/**
 * Created by PhpStorm.
 * User: jskka
 * Date: 26/03/2018
 * Time: 00:46
 */

namespace ProduitBundle\Controller;
use FOS\UserBundle\Model\UserInterface;
use MailBundle\Entity\Mail;
use MailBundle\Form\MailType;
use MainBundle\Entity\Notification;
use MainBundle\Entity\Produit;
use MainBundle\Entity\Promotion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use UserBundle\Entity\User;
use Swift_Message;

use ProduitBundle\Form\ProduitType;


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
            ->add('description', TextareaType::class)
            ->add('prix', TextType::class)
            ->add('image', FileType::class, array('label' => 'Image(JPG)'))

            ->add('quantite', TextType::class)
            ->add('Ajouter', SubmitType::class, array())

            ->getForm();

        $form->handleRequest($request);
        if ($form->isValid()) {

            $user = $this->getUser();
            $po->setIdartisan($user->getId());
            $em = $this->getDoctrine()->getManager();

            $em->persist($po);
            $em->flush();


            $n=new Notification();
            $n->setIdUser($user);
            $n->setMessage($user->getPrenom()." added a new product");
            $n->setSubject("");
            $n->setSeen(0);
            $n->setLink("");
            $n->setIdProduit($po);
            $em1= $this->getDoctrine()->getManager();
            $em1->persist($n);
            $em1->flush();








        }

        $em = $this->getDoctrine()->getManager();
        $notif = $em->getRepository(Notification::class)->findAll();
        return $this->render('ProduitBundle:Produit:ajouter.html.twig',
            ['form' => $form->createView(),'notifs'=>$notif]);
        }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function supprimerProduitAction(Request $request )
    {
        $em=$this->getDoctrine()->getManager();
        $produit=$em->getRepository(Produit::class)->find($request->get("id"));
        $em->remove($produit);
        $em->flush();
        return $this->redirectToRoute("main_homepage");

    }


    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function renderAction(Request $request)
    {
        return $this->render('ProduitBundle:Produit:update.html.twig' , [
            'id' => $request->query->get('id')
        ]);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function updateAction(Request $request)
    {
        $id = $request->query->get('id');
        $em = $this->getDoctrine()->getManager();
        $prod = $em->getRepository("MainBundle:Produit")->find($id);

        $data = [
            'titre' => $request->get('titre'),
            'prix' => $request->get('prix'),
            'quantite' => $request->get('quantite'),
            'description' => $request->get('description'),
        ];
        $prod->setTitre($data['titre']);
        $prod->setPrix($data['prix']);
        $prod->setQuantite($data['quantite']);
        $prod->setDescription($data['description']);
        $em->persist($prod);
        $em->flush();

        return $this->redirectToRoute('ff');
    }
    /**
     * @param Request $request
     * @return Response
     */
    public function RechercheAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $titre = trim(strtolower($request->get('text')));
        $conn=$this->getDoctrine()->getConnection() ;
        $query = "SELECT * FROM produit WHERE titre LIKE '%" . $titre . "%' ;";
        $stmt = $conn->prepare($query);
        $stmt->execute([]);

        $user = $em->getRepository(User::class)->findAll();
        $notif = $em->getRepository(Notification::class)->findAll();
        $promotion = $this->getDoctrine()->getRepository(Promotion::class)->findAll();
        $users = $em->getRepository(User::class)->findAll();
        $produits=$stmt->fetchAll();;

        return $this->render("ProduitBundle:Produit:recherche.html.twig",['produits'=>$produits,'users' => $users,'user' => $user, 'notifs'=>$notif,'produitp'=> $promotion]);
    }
}