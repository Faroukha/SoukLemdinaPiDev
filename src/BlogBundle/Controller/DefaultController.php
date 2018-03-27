<?php

namespace BlogBundle\Controller;

use MainBundle\Entity\Blog;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Entity\User;

class DefaultController extends Controller
{
    public function blogAction()
    {$em = $this->getDoctrine()->getManager();
        $Blogs=$em->getRepository(Blog::class)->findAll();
        return $this->render('BlogBundle:Default:blog.html.twig',['Blogs' => $Blogs]);
    }
    public function blogDetailAction()
    {
        return $this->render('BlogBundle:Default:blogDetail.html.twig');
    }

    public function ajouterBlogAction(Request $request){
        $Blog = new Blog();
        if ($request->isMethod('POST')) {
            $Blog->setTitre($request-> get('titre'));
//            $Blog->setDateBlog($request->get('dateBlog')) ;
            $Blog->setDescription($request->get('description'));
            $Blog->setImage($request->get('image'));
            $Blog->setNbrLike(0);
            $em = $this->getDoctrine()->getManager();
            $user =$em ->getRepository(User::class)->find($request->get('idUser'));
            $Blog ->setIdUser($user);


            $em->persist($Blog);
            $em->flush();
        }
        return $this->redirectToRoute('blog');

    }
    public function ishowBlogAction()
    {

        return $this->render('BlogBundle:Default:addBlog.html.twig' );
    }
}
