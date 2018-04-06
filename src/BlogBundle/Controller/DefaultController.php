<?php

namespace BlogBundle\Controller;

use http\Env\Response;
use MainBundle\Entity\Blog;
use MainBundle\Entity\Commentaire;
use MainBundle\Entity\CommentaireBlog;
use MainBundle\Entity\Notification;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class DefaultController extends Controller
{
    public function blogAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        $notif = $em->getRepository(Notification::class)->findAll();
        $Blogs = $em->getRepository(Blog::class)->findAll();
        $user = $em->getRepository(User::class)->findAll();
        $paginator = $this->get('knp_paginator');

        $Blogs = $paginator->paginate(
            $Blogs,
            $request->query->getInt('page', 1)/*page number*/,
            $request->query->getInt('limit', 2)/*limit per page*/
        );


        return $this->render('BlogBundle:Default:blog.html.twig', ['Blogs' => $Blogs,'users'=>$user, 'notifs'=>$notif]);
    }

    public function blogDetailAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $Blogs = $em->getRepository(Blog::class)->find($request->get('id'));
        $Coms = $em->getRepository(CommentaireBlog::class)->findByidBlog($request->get('id'));
        $notif = $em->getRepository(Notification::class)->findAll();

        return $this->render('BlogBundle:Default:blogDetail.html.twig', ['Blog' => $Blogs ,'Com' => $Coms, 'notifs'=>$notif]);
    }

//    public function ajouterBlogAction(Request $request)
//    {
//        $Blog = new Blog();
//        if ($request->isMethod('POST')) {
//            $Blog->setTitre($request->get('titre'));
//
//            $Blog->setDescription($request->get('description'));
//            $Blog->setImage($request->get('image'));
//            $Blog->setNbrLike(0);
//            $em = $this->getDoctrine()->getManager();
//            $user = $em->getRepository(User::class)->find($request->get('idUser'));
//            $Blog->setIdUser($user);
//
//
//            $em->persist($Blog);
//            $em->flush();
//        }
//        return $this->redirectToRoute('blog');
//
//    }
    public function ajouterBlogAction(Request $request )
    {
        $Blog = new Blog();

        $form = $this->createFormBuilder($Blog)

            ->add('titre', TextType::class)
            ->add('description', TextType::class)
            ->add('image', FileType::class, array('label' => 'Image(JPG)'))
            ->add('Submit', SubmitType::class, array())
            ->getForm();

        $form->handleRequest($request);
        if ($form->isValid()) {
            $user = $this->getUser();
            $Blog->setIdUser($user->getId());

            $em = $this->getDoctrine()->getManager();
            $em->persist($Blog);
            $em->flush();
        }
        return $this->render('BlogBundle:Default:addBlog.html.twig',
            ['form' => $form->createView()]);
    }

    public function ishowBlogAction()
    {

        return $this->render('BlogBundle:Default:addBlog.html.twig');
    }

    public function addComAction(Request $request)
    {
        $Com = new CommentaireBlog();

            $Com->setDescription($request->get('description'));
            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository(User::class)->find($request->get('idUser'));
            $Blog = $em->getRepository(Blog::class)->find($request->get('idBlog'));
        $notif = $em->getRepository(Notification::class)->findAll();

        $Com->setIdUser($user);
            $Com->setIdBlog($Blog);
            $em->persist($Com);
            $em->flush();
        $Coms = $em->getRepository(CommentaireBlog::class)->findAll();
        return $this->render('BlogBundle:Default:blogDetail.html.twig', ['Blog' => $Blog ,'Com' => $Coms, 'notifs'=>$notif]);
    }

    public function delComAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $Com=$em->getRepository(CommentaireBlog::class)->find($request->get("idCom"));;
        $em->remove($Com);
        $em->flush();


        $em = $this->getDoctrine()->getManager();
        $notif = $em->getRepository(Notification::class)->findAll();

        $Blogs = $em->getRepository(Blog::class)->find($request->get('id'));
        $Coms = $em->getRepository(CommentaireBlog::class)->findByidBlog($request->get('id'));
        return $this->render('BlogBundle:Default:blogDetail.html.twig', ['Blog' => $Blogs ,'Com' => $Coms,'notifs'=>$notif]);
    }

    public function deleteBlogAction(Request $request){
        $em=$this->getDoctrine()->getManager();
        $blog=$em->getRepository(Blog::class)->find($request->get("id"));;
        $em->remove($blog);
        $em->flush();
        return $this->redirectToRoute("blog");
    }
}

