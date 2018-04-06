<?php

namespace AdminBundle\Controller;

use AdminBundle\AdminBundle;
use MainBundle\Entity\Contact;
use MainBundle\Entity\Pubg;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\DateTime;


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
        return $this->render('AdminBundle:Pub:ajouterPub.html.twig');
    }

//    public function addPubAction(Request $request)
//    {
//
//        $pub = new Pubg();
//        if ($request->isMethod('POST')) {
//            if (($request->get("datedeb")) > $request->get("datefin")) {
//                return $this->redirectToRoute('ajouterPub');
//            } else {
//                $pub->setDatedeb(new \DateTime($request->get("datedeb")));
//                $pub->setDatefin(new \DateTime($request->get("datefin")));
//            }
//
//            $pub->setImage($request->get('image'));
//            $em = $this->getDoctrine()->getManager();
//            $em->persist($pub);
//            $em->flush();
//        }
//        return $this->redirectToRoute('allPub');
//
//    }

    public function addpubAction(Request $request)
    {
        $pub = new Pubg();


        $form = $this->createFormBuilder($pub)
            ->add('datedeb', DateType::class)
            ->add('datefin', DateType::class)
            ->add('image', FileType::class, array('label' => 'Image(JPG)'))
            ->add('Ajouter', SubmitType::class, array())
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            if ($pub->getDatedeb() <= $pub->getDatefin()) {

                $em = $this->getDoctrine()->getManager();
                $em->persist($pub);
                $em->flush();
            }
        }


        return $this->render('AdminBundle:Pub:ajouterPub.html.twig',
            ['form' => $form->createView()]);
    }

    public function updatePubAction(Request $request)
    {
        $id = $request->query->get('id');
        $em = $this->getDoctrine()->getManager();
        $pub = $em->getRepository("MainBundle:Pubg")->find($id);

        $data = [
            'datedeb' => $request->get('datedeb'),
            'datefin' => $request->get('datefin'),
        ];
        if ($pub->getDatedeb() <= $pub->getDatefin()) {
            $pub->setDatedeb($data['datedeb']);
            $pub->setDatefin($data['datefin']);

            $em->persist($pub);
            $em->flush();
        }
        return $this->redirectToRoute('allPub');
    }


    public function updatePubViewAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $id = $em->getRepository(Pubg::class)->find($request->get("id"));
        return $this->render('AdminBundle:Pub:updatePub.html.twig', ['id' => $id]);
    }

    public function deletePubAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $pub = $em->getRepository(Pubg::class)->find($request->get("id"));
        $em->remove($pub);
        $em->flush();
        return $this->redirectToRoute("allPub");

    }

    public function allreclamAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        $rec = $em->getRepository(Contact::class)->findAll();

        $paginator = $this->get('knp_paginator');

        $Reclamation = $paginator->paginate(
            $rec,
            $request->query->getInt('page', 1)/*page number*/,
            $request->query->getInt('limit', 5)/*limit per page*/
        );

        return $this->render('AdminBundle::allreclamation.html.twig', [
            'recs' => $Reclamation,
        ]);

    }

    public  function reclamerAction (Request $request){
        $em = $this->getDoctrine()->getManager();
        $rec = $em->getRepository(Contact::class)->find($request->get("id"));

        if($rec->getEtat()==false) {
            $rec ->setEtat(true) ;
            $em->persist($rec);
            $em->flush();
        }

        return $this->redirectToRoute('allreclam');
    }

}
