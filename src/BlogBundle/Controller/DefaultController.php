<?php

namespace BlogBundle\Controller;

use http\Env\Response;
use MainBundle\Entity\Blog;
use MainBundle\Entity\Commentaire;
use MainBundle\Entity\CommentaireBlog;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Entity\User;

class DefaultController extends Controller
{
    public function blogAction()
    {
        $em = $this->getDoctrine()->getManager();
        $Blogs = $em->getRepository(Blog::class)->findAll();
        return $this->render('BlogBundle:Default:blog.html.twig', ['Blogs' => $Blogs]);
    }

    public function blogDetailAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $Blogs = $em->getRepository(Blog::class)->find($request->get('id'));
        $Coms = $em->getRepository(CommentaireBlog::class)->findByidBlog($request->get('id'));
        return $this->render('BlogBundle:Default:blogDetail.html.twig', ['Blog' => $Blogs ,'Com' => $Coms]);
    }

    public function ajouterBlogAction(Request $request)
    {
        $Blog = new Blog();
        if ($request->isMethod('POST')) {
            $Blog->setTitre($request->get('titre'));
//            $Blog->setDateBlog($request->get('dateBlog')) ;
            $Blog->setDescription($request->get('description'));
            $Blog->setImage($request->get('image'));
            $Blog->setNbrLike(0);
            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository(User::class)->find($request->get('idUser'));
            $Blog->setIdUser($user);


            $em->persist($Blog);
            $em->flush();
        }
        return $this->redirectToRoute('blog');

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
            $Com->setIdUser($user);
            $Com->setIdBlog($Blog);
            $em->persist($Com);
            $em->flush();
        $Coms = $em->getRepository(CommentaireBlog::class)->findAll();
        return $this->render('BlogBundle:Default:blogDetail.html.twig', ['Blog' => $Blog ,'Com' => $Coms]);
    }

    public function delComAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $Com=$em->getRepository(CommentaireBlog::class)->find($request->get("idCom"));;
        $em->remove($Com);
        $em->flush();


        $em = $this->getDoctrine()->getManager();
        $Blogs = $em->getRepository(Blog::class)->find($request->get('id'));
        $Coms = $em->getRepository(CommentaireBlog::class)->findByidBlog($request->get('id'));
        return $this->render('BlogBundle:Default:blogDetail.html.twig', ['Blog' => $Blogs ,'Com' => $Coms]);
    }
}

