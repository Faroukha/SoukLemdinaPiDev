<?php

namespace AdminBundle\Controller;

use AdminBundle\AdminBundle;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use EvenementBundle\Entity\Event;
use MainBundle\Entity\Blog;
use MainBundle\Entity\Contact;
use MainBundle\Entity\Etat;
use MainBundle\Entity\Produit;
use MainBundle\Entity\Pubg;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\DateTime;
use UserBundle\Entity\User;


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
        $pub = $em->getRepository(Pubg::class)->find($request->get("id"));
        return $this->render('AdminBundle:Pub:updatePub.html.twig', ['id' => $id,'pubs'=>$pub]);
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
        $em1 =$this->getDoctrine()->getManager();
               $em2 =$this->getDoctrine()->getManager();

                $etat = $em1->getRepository(Etat::class)->find(1);
                $etat ->setNbr($etat ->getNbr() +1) ;

                $etat2 =$em2->getRepository(Etat::class)->find(2);
                $etat2 ->setNbr($etat2->getNbr()-1);

        if($rec->getEtat()==false) {
            $rec ->setEtat(true) ;
            $em->persist($rec);
            $em->flush();

            $em1->persist($etat);
                        $em1->flush();
                        $em2->persist($etat2);
                        $em2->flush();
        }

        return $this->redirectToRoute('allreclam');
    }

    public function blogsAction(){
        $em = $this->getDoctrine()->getManager();
        $blog = $em->getRepository(Blog::class)->findAll();
        return $this->render('AdminBundle:Elements:blog.html.twig', ['blog'=>$blog]);
    }
    public function deleteBlogAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $blog = $em->getRepository(Blog::class)->find($request->get("id"));;
        $em->remove($blog);
        $em->flush();
        return $this->redirectToRoute("all_blogs");
    }
    public function deleteEventAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $blog = $em->getRepository(Event::class)->find($request->get("id"));;
        $em->remove($blog);
        $em->flush();
        return $this->redirectToRoute("all_eventss");
    }
    public function deleteProduitAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $blog = $em->getRepository(Produit::class)->find($request->get("id"));;
        $em->remove($blog);
        $em->flush();
        return $this->redirectToRoute("all_produitss");
    }

    public function eventsAction(){
        $em = $this->getDoctrine()->getManager();
        $event = $em->getRepository(Event::class)->findAll();
        return $this->render('AdminBundle:Elements:events.html.twig', ['events'=>$event]);
    }

    public function usersAction(){
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->findAll();
        return $this->render('AdminBundle:Elements:users.html.twig', ['user'=>$user]);
    }

    public function produitsAction(){
        $em = $this->getDoctrine()->getManager();
        $produit = $em->getRepository(Produit::class)->findAll();
        return $this->render('AdminBundle:Elements:produits.html.twig', ['produits'=>$produit]);
    }

   public function StatistiqueAction()
    {
        $pieChart = new PieChart();
        $em= $this->getDoctrine();

        $test = $em->getRepository(Etat::class)->findAll();

        $data= array();
        $stat=['etat', 'nbr'];
        $nb=0;
        array_push($data,$stat);
        foreach($test as $tests) {
            $stat=array();

            array_push($stat,$tests->getInfo(), $tests->getNbr());
            $nb=($tests->getNbr());
            $stat=[$tests->getInfo(),$nb];
            array_push($data,$stat);
        }
        $pieChart->getData()->setArrayToDataTable(
                $data
           );
        $pieChart->getOptions()->setTitle('Statistique sur les reclamations');
        $pieChart->getOptions()->setHeight(500);
        $pieChart->getOptions()->setWidth(900);
        $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChart->getOptions()->getTitleTextStyle()->setColor('#009900');
        $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
        $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $pieChart->getOptions()->getTitleTextStyle()->setFontSize(20);
        return $this->render('AdminBundle::stat.html.twig', array('piechart' =>
                $pieChart));
    }
}
