<?php

namespace EcommerceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;
use MainBundle\Entity\Produit;
use MainBundle\Entity\Panier;
use MainBundle\Entity\Produitspanier;

use UserBundle\Entity\User;
use Symfony\Component\HttpFoundation\RedirectResponse;
class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        $em=$this->getDoctrine()->getRepository(Produitspanier::class);
        $es=$this->getDoctrine()->getRepository(Produit::class);

        $Produitpanier=$em->findAll();
        $Produit=$es->findAll();

        return $this->render('EcommerceBundle:Default:index.html.twig',['Produitpanier'=>$Produitpanier,'Produit'=>$Produit]);

    }

    public function AddToCartAction(Request $request)
    {

        /*$session = $this->getRequest()->getSession();

        if (!$session->has('panier')) $session->set('panier',array());
        $panier = $session->get('panier');

        if (array_key_exists($id, $panier)) {
            if ($this->getRequest()->query->get('qte') != null) $panier[$id] = $this->getRequest()->query->get('qte');
            $this->get('session')->getFlashBag()->add('success','Quantité modifié avec succès');
        } else {
            if ($this->getRequest()->query->get('qte') != null)
                $panier[$id] = $this->getRequest()->query->get('qte');
            else
                $panier[$id] = 1;

            $this->get('session')->getFlashBag()->add('success','Article ajouté avec succès');
        }

        $session->set('panier',$panier);


        return $this->redirect($this->generateUrl('ecommerce_homepage'));*/
        /* $panier = $session->get('panier');
         $session->replace(array('panier' => $panier." ".$id));*/

        // return $this->render('EcommerceBundle:Default:index.html.twig');
        $user = $this->getUser();
        $panier=new Panier();
        $panier->setIduser($user->getId());
        $panier->setPrixtotal(0);
        $iduserConnected=$user->getId();

        $Produitpanier = new Produitspanier();
        if ($request->isMethod('POST') && $iduserConnected== $panier->getIduser()) {
            $Produitpanier->setIdpanier($panier->getId());
            $Produitpanier->setIdproduit($request->get('idproduit')) ;
            $Produitpanier->setNomproduit($request->get('titreproduit'));
            $Produitpanier->setQuantite($request->get('quantite'));

            $em = $this->getDoctrine()->getManager();
            $em->persist($Produitpanier);
            $em->flush();
        }
        return $this->redirectToRoute('redirecttohome');
        //return $this->render('EcommerceBundle:Default:index.html.twig');
    }
}
