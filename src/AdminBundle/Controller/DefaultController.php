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

    public function allPubAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        $Pubss = $em->getRepository(Pubg::class)->findAll();

        $paginator = $this->get('knp_paginator');

        $Pubs = $paginator->paginate(
            $Pubss,
            $request->query->getInt('page', 1)/*page number*/,
            $request->query->getInt('limit', 5)/*limit per page*/
        );

        return $this->render('AdminBundle::AllPub.html.twig', [
            'pubs' => $Pubs,
        ]);

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
//                    && ($request->get("datedeb") < "now"|date("m/d/Y")
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
