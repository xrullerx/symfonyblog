<?php

namespace Blogger\BlogBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

// Репозиторий пользователей.
class UserRepository extends EntityRepository
{
    // Поиск пользователя по логину и паролю.
    public function equalsUser($name, $psw)
    {
        $em = $this->getEntityManager(); //Получение связи с менеджером Сущщностей.
        $user = $em->getRepository('BloggerBlogBundle:User')->findBy(array('name'=>$name, 'psw'=>$psw)); 
        return !(empty($user)); 
    }  
}

