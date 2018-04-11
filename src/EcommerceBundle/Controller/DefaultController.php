<?php

namespace EcommerceBundle\Controller;

use MainBundle\Entity\Coupon;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use MainBundle\Entity\Produit;
use MainBundle\Entity\Panier;
use MainBundle\Entity\Commande;
use MainBundle\Entity\Produitspanier;

use Knp\Bundle\SnappyBundle\Snappy;

use UserBundle\Entity\User;
use Symfony\Component\HttpFoundation\RedirectResponse;
class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        $em=$this->getDoctrine()->getRepository(Produitspanier::class);
        $es=$this->getDoctrine()->getRepository(Produit::class);
        $eg=$this->getDoctrine()->getRepository(Panier::class);

        $Produit=$es->findAll();
        $userConnected = $this->getUser();
        $panier=$eg->findByIduser($userConnected->getId());
        foreach ($panier as $p){
        $Produitpanier=$em->findByIdpanier($p->getId());

        }






        return $this->render('EcommerceBundle:Default:index.html.twig',['Produitpanier'=>$Produitpanier,'Produit'=>$Produit,'Panier'=>$panier]);

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



      /*  $panier->setIduser($user->getId());
        $panier->setPrixtotal(0);*/
        $userConnected = $this->getUser();

        $em=$this->getDoctrine()->getRepository(Panier::class);
        $panier=$em->findAll();

foreach ($panier as $p){

    if(($p->getIduser()==$userConnected->getId()) &&($request->isMethod('POST')))

    {
        $Produitpanier = new Produitspanier();
if($p->getPrixtotal()!= 0)
{ $p->setPrixtotal(0);}
else{

            $Produitpanier->setIdpanier($p->getId());
            $Produitpanier->setIdproduit($request->get('idproduit')) ;
            $Produitpanier->setNomproduit($request->get('titreproduit'));
            $Produitpanier->setQuantite($request->get('quantite'));
            $em = $this->getDoctrine()->getManager();
            $em->persist($Produitpanier);
            $em->flush();}
            //$lastid=$Produitpanier->getIdpanier();



    }elseif( $p->getIduser()!=$userConnected->getId() && $p->getIduser()==0 )
    {

        $Produitpanier = new Produitspanier();
            $panierr=new panier();
            $panierr->setPrixtotal(0);
            $panierr->setIduser($userConnected->getId());

            $em = $this->getDoctrine()->getManager();
            $em->persist($panierr);
            $em->flush();
            $Produitpanier->setIdpanier($panierr->getId());
            $Produitpanier->setIdproduit($request->get('idproduit')) ;
            $Produitpanier->setNomproduit($request->get('titreproduit'));
            $Produitpanier->setQuantite($request->get('quantite'));
           $es = $this->getDoctrine()->getManager();
            $es->persist($Produitpanier);
            $es->flush();


   }}











        return $this->redirectToRoute('redirecttohome');
        //return $this->render('EcommerceBundle:Default:index.html.twig');
    }

public function removeItemAction(Request $request)
{
    $em=$this->getDoctrine()->getManager();
    $pr=$em->getRepository(Produitspanier::class)->findByIdproduit($request->get("idProduit"));
   // var_dump($request->get("idProduit"));
    //die();
    foreach ($pr as $p) {
        $em->remove($p);
    }

    $em->flush();
    return $this->redirectToRoute("ecommerce_homepage");
}

    public function updateItemAction(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $product = $entityManager->getRepository(Produitspanier::class)->findByIdproduit($request->get("idProduit"));
        foreach ($product as $p) {
          $p->setQuantite($request->get("quantity"));
            $entityManager->persist($p);
          //var_dump($p->getQuantite());

        }



        $entityManager->flush();
        return $this->redirectToRoute("ecommerce_homepage");
    }

    public function ApplyCouponAction(Request $request)
    {
        $user=$this->getUser();
        $entityManager = $this->getDoctrine()->getManager();
        $coupon = $entityManager->getRepository(Coupon::class)->findAll();
        $panier = $entityManager->getRepository(Panier::class)->findByIduser($user->getId());
        foreach ($coupon as $p) {
            if($p->getNumero()==$request->get("coupon"));
            foreach ($panier as $pa) {
                $pa->setPrixtotal($p->getTaux()*$pa->getPrixtotal()/100);
            }
            $entityManager->persist($pa);
            //var_dump($p->getQuantite());

        }
        $entityManager->flush();
        return $this->redirectToRoute("ecommerce_homepage");

    }

    public function ValiderAchatAction(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $panier = $entityManager->getRepository(Panier::class)->findByIduser($this->getUser()->getId());

        foreach ($panier as $p) {
            //var_dump($request->get("total"));
            if($p->getPrixtotal()==0) {
                $p->setPrixtotal($request->get("total"));

                $entityManager->persist($p);
                $prr = $entityManager->getRepository(Produitspanier::class)->findByIdpanier($p->getId());
                foreach ($prr as $pr) {
                    $entityManager->remove($pr);
                }
                //var_dump($p->getQuantite());
            }else{
                return $this->render('@Ecommerce/Default/passercommande.html.twig');
            }

        }

//die();
        $entityManager->flush();
        return $this->render('@Ecommerce/Default/passercommande.html.twig');
    }


    public function PasserCommandeAction(Request $request)
    {

        $entityManager = $this->getDoctrine()->getManager();
        $panier = $entityManager->getRepository(Panier::class)->findByIduser($this->getUser()->getId());
        $commande= new Commande();
        foreach($panier as $p)
        {
            $commande->setIdpanier($p->getId());
            $commande->setIduser($this->getUser()->getId());
            $commande->setDate(new \DateTime('now'));
            $commande->setEtat(false);
            $entityManager->persist($commande);

        }

        $entityManager->flush();
        return $this->redirectToRoute('redirecttohome');

    }

    public function ValiderCommandeAction(Request $request)
    {

        $entityManager = $this->getDoctrine()->getManager();
        $panier = $entityManager->getRepository(Panier::class)->findByIduser($this->getUser()->getId());
        $commande = $entityManager->getRepository(Panier::class)->findAll();

        foreach($commande as $p)
        {
           if($commande->getEtat()==false)
           {
               $commande->setEtat(true);
               $entityManager->persist($commande);
           }
        }
        $entityManager->flush();
        return $this->redirectToRoute('PasserCommande');

    }

    public function listerCommandesAction()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $panier = $entityManager->getRepository(Panier::class)->findByIduser($this->getUser()->getId());
        $commande = $entityManager->getRepository(Commande::class)->findByIduser($this->getUser()->getId());




        $html = $this->renderView('EcommerceBundle:Default:ListeCommandes.html.twig', array(
            'commande'  => $commande));

        $filename = sprintf('test-%s.pdf', date('Y-m-d'));

        return new Response(
            $this->get('knp_snappy.pdf')->getOutputFromHtml($html),
            200,
            [
                'Content-Type'        => 'application/pdf',
                'Content-Disposition' => sprintf('attachment; filename="%s"', $filename),
            ]
        );





        //$lc= $this->renderView('EcommerceBundle:Default:ListeCommandes.html.twig',['commande'=>$commande]);
       // $snapper=$this->get('knp_snappy.pdf');
        //$filename="file";
        //return new Response($snapper->getOutputFromHtml($lc),200,array('content-Type'=>'application/pdf',
            //'content-Disposition'=>'inline;filename"'.$filename.'.pdf"' ));
       /* $this->get('knp_snappy.pdf')->generateFromHtml(
            $this->renderView(
                'EcommerceBundle:Default:ListeCommandes.html.twig',
                array(
                    'commande'=>$commande
                )
            ),
            '/path/to/the/file.pdf'
        );*/
       /* $html = $this->renderView('EcommerceBundle:Default:ListeCommandes.html.twig', array(
            'Commande'  => $commande
        ));

        return new Response(
            $this->get('knp_snappy.pdf')->generateFromHtml($html),
            'file.pdf'
        );*/


    }









}
