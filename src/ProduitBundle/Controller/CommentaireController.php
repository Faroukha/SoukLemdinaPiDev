<?php
/**
 * Created by PhpStorm.
 * User: jskka
 * Date: 28/03/2018
 * Time: 00:26
 */

namespace ProduitBundle\Controller;

use MainBundle\Entity\Commentaire;
use MainBundle\Entity\Notification;
use MainBundle\Entity\Produit;
use ProduitBundle\Entity\Avis;
use ProduitBundle\Form\RatingType;
use ProduitBundle\ProduitBundle;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use UserBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
class CommentaireController extends Controller
{

    public function addCommentaireAction(Request $request)
    {
        $commentaire = new Commentaire();

        $commentaire->setText($request->get('text'));
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->find($request->get('idUser'));
        $produit = $em->getRepository(Produit::class)->find($request->get('id'));
        $notif = $em->getRepository(Notification::class)->findAll();



        $commentaire->setEmailuser($user);
        $commentaire->setIdproduit($request->get('id'));

        $em->persist($commentaire);
        $em->flush();
        $Coms = $em->getRepository(Commentaire::class)->findAll();
        $f=$em->getRepository("ProduitBundle:Avis");



        return $this->redirectToRoute('ff', [array('f'=>$f),'commentaire' => $Coms,'produit'=>$produit,'notifs'=>$notif]);
    }

}