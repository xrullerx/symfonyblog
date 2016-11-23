<?php

namespace Blogger\BlogBundle\Controller;

use Blogger\BlogBundle\Entity\Blog;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Blogger\BlogBundle\Form\BlogType;


/**
 * Контроллер блога
 */
class BlogController extends Controller
{
    /**
     * Вывод списка блогов
     */
    public function showAction($id, $slug)
    {
        $_SESSION['USER'] = 'Guest';
        $em = $this->getDoctrine()->getManager();

        $blog = $em->getRepository('BloggerBlogBundle:Blog')->find($id);
        
        if (!$blog) 
        {
            throw $this->createNotFoundException('Невозможно найти в блоге пост.');
        }

        $comments = $em->getRepository('BloggerBlogBundle:Comment')
                       ->getCommentsForBlog($blog->getId());

        return $this->render('BloggerBlogBundle:Blog:show.html.twig', array(
            'blog'      => $blog,
            'comments'  => $comments));        
    }
    
    /**
     * Создание редактирование блога
     */    
    public function createAction(Request $request, $blog_id)
    {
        // В зависимости от $blog_id - редактируем или создаем блог
        if ($blog_id > 0)
        {
            $embl = $this->getDoctrine()->getManager();
            $blog = $embl->getRepository('BloggerBlogBundle:Blog')->find($blog_id);            
        }
        else
        {            
            $blog = new Blog();
        }
        
        $form = $this->createForm(BlogType::class, $blog);     
        $form->handleRequest($request);   
        
        // В случае валидности данных - сохраняем в базе данных.
        if ($form->isValid()) 
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($blog);
            $em->flush();
            // Переходим в основную страницу.
            return $this->redirect($this->generateUrl('BloggerBlogBundle_homepage'));
        }
        
        // Создаем страницу создания блога.
        return $this->render('BloggerBlogBundle:Blog:create.html.twig', array(
            'blog_id' => $blog_id,
            'form' => $form->createView()));            
    }    
}
