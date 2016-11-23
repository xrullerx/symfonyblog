<?php
namespace Blogger\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Blogger\BlogBundle\Entity\Enquiry;
use Blogger\BlogBundle\Form\EnquiryType;

// Контроллер основной страницы.
class PageController extends Controller
{
    // Вывод всех блогов.
    public function indexAction()
    {        
        $em = $this->getDoctrine()
                   ->getManager();

        $blogs = $em->getRepository('BloggerBlogBundle:Blog')
                    ->getLatestBlogs();

        return $this->render('BloggerBlogBundle:Page:index.html.twig', array(
            'blogs' => $blogs));        
    }
    
    // Переход на страницу "о блоге".
    public function aboutAction()
    {
        return $this->render('BloggerBlogBundle:Page:about.html.twig');
    }
    
    // Переход на страницу контакта.
    public function contactAction(Request $request)
    {
        $enquiry = new Enquiry();

        $form = $this->createForm(EnquiryType::class, $enquiry);

        if ($request->isMethod($request::METHOD_POST)) 
        {
            $form->handleRequest($request);
            if ($form->isValid()) 
            {
                return $this->redirect($this->generateUrl('BloggerBlogBundle_contact'));
            }
        }
        return $this->render('BloggerBlogBundle:Page:contact.html.twig', array(
            'form' => $form->createView()));
    }
    
    // Вывод бокового бара на основной странице.
    public function sidebarAction()
    {
        $em = $this->getDoctrine()->getManager();

        $tags = $em->getRepository('BloggerBlogBundle:Blog')
                   ->getTags();

        $tagWeights = $em->getRepository('BloggerBlogBundle:Blog')
                         ->getTagWeights($tags);

        $commentLimit   = $this->container
                         ->getParameter('blogger_blog.comments.latest_comment_limit');
        
        $latestComments = $em->getRepository('BloggerBlogBundle:Comment')
                         ->getLatestComments($commentLimit);
        if (empty($_SESSION['USER']))
        {
            $_SESSION['USER'] = 'Guest';
        }            
        return $this->render('BloggerBlogBundle:Page:sidebar.html.twig', array(
            'latestComments'    => $latestComments,
            'tags'              => $tagWeights,
            'user'              => $_SESSION['USER']));        
    }
}
