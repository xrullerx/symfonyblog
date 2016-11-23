<?php
namespace Blogger\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Blogger\BlogBundle\Entity\User;
use Blogger\BlogBundle\Form\UserType;
use Blogger\BlogBundle\Form\LoginUserType;

// Контроллер пользователей.
class UserController extends Controller
{
    // Переход на страницу регистрации нового пользователя.
    public function registrationAction(Request $request)
    {        
        $user = new User();
        $form = $this->createForm(UserType::class, $user);      
        $form->handleRequest($request);
        if ($form->isValid()) 
        {
            // Получить значения полей формы.
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            // Если оба пароля совпадают - регистрация успешна.
            if ($user->equalsPsw())
            {
                $em->flush();
                $_SESSION['USER'] = $user->getName();
                return $this->redirect($this->generateUrl('BloggerBlogBundle_homepage'));
            }
            // Повторяем регистрацию.
            $em->clear();
            return $this->redirect($this->generateUrl('BloggerBlogBundle_user_create'));
        }
        return $this->render('BloggerBlogBundle:user:registration.html.twig', array(
            'form' => $form->createView()));        
    }
    
    // Переход на страницу аутоидентификации.
    public function signinAction(Request $request)
    {        
        $user = new User();
        $form = $this->createForm(LoginUserType::class, $user);
        $form->handleRequest($request);
        if ($form->isValid()) 
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);            
            $userrep = $em->getRepository('BloggerBlogBundle:User')
                       ->equalsUser($user->getName(), $user->getPsw());
            // Есои пользователь найден - идентификация успешна.
            if ($userrep)
            {                
                $em->clear();
                $_SESSION['USER'] = $user->getName();
                return $this->redirect($this->generateUrl('BloggerBlogBundle_homepage'));            
            }
            // остаемся на странице. 
            $em->clear();
            $_SESSION['USER'] = 'Guest';
        }
        return $this->render('BloggerBlogBundle:user:signin.html.twig', array(
            'form' => $form->createView()));        
    }           
   
 }
