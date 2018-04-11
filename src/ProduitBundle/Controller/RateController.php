<?php
/**
 * Created by PhpStorm.
 * User: jskka
 * Date: 09/04/2018
 * Time: 19:23
 */

namespace ProduitBundle\Controller;

use MainBundle\Entity\Commentaire;
use MainBundle\Entity\Notification;
use MainBundle\Entity\Produit;
use ProduitBundle\Entity\Avis;
use ProduitBundle\Form\RatingType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;



class RateController extends Controller
{

    public function infoAction($id,Request $request){

        $em=$this->getDoctrine()->getManager();
        $notif = $em->getRepository(Notification::class)->findAll();
        $em=$this->getDoctrine()->getRepository(Produit::class);
        $es=$this->getDoctrine()->getRepository(Commentaire::class);
        $commentaire=$es->findAll();
        $produit=$em->find($request->get('id'));



        $rating = new Avis();
        $m = $this->getDoctrine()->getManager();
        $mark = $m->getRepository(Produit::class)->find($id);
        $form = $this->createFormBuilder($rating)
            ->add('rating', RatingType::class, [
                'label' => 'Rating'
            ])
            ->add('valider', SubmitType::class, array(
                'attr' => array(

                    'class' => 'btn btn-xs btn-primary'
                )))
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $rating->setIdE($mark->getId());
            $m->persist($rating);
            $m->flush();
        }

        $data=array(
            'm' => $mark,
            'f' => $form->createView(),
            'notifs'=>$notif,
            'produit'=>$produit,
            'commentaire'=>$commentaire
        );

        return $this->render('ProduitBundle:Produit:product-details.html.twig',$data);





    }



}