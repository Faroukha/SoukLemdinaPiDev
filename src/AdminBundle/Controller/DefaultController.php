<?php

namespace AdminBundle\Controller;

use MainBundle\Entity\Pubg;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('AdminBundle::admin.html.twig');
    }

    public function allPubAction()
    {
        $em = $this->getDoctrine()->getManager();
        $Pubs = $em->getRepository(Pubg::class)->findAll();
        return $this->render('AdminBundle::AllPub.html.twig', ['pubs' => $Pubs]);
    }

    public function ajouterPubAction()
    {
        return $this->render('AdminBundle::ajouterPub.html.twig');
    }

    public function addPubAction(Request $request)
    {

        $pub = new Pubg();
        if ($request->isMethod('POST')) {
            if (($request->get("datedeb")) > $request->get("datefin")) {
                return $this->redirectToRoute('ajouterPub');
            } else {
                $pub->setDatedeb(new \DateTime($request->get("datedeb")));
                $pub->setDatefin(new \DateTime($request->get("datefin")));
            }

            $pub->setImage($request->get('image'));
            $em = $this->getDoctrine()->getManager();
            $em->persist($pub);
            $em->flush();
        }
        return $this->redirectToRoute('allPub');

    }
}
