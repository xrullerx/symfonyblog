<?php

namespace Blogger\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Blogger\BlogBundle\Entity\Repository\UserRepository")
 * @ORM\Table(name="user")
 * @ORM\HasLifecycleCallbacks()
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @ORM\Column(type="string")
     */
    protected $psw;
    
    protected $repeatPsw;
    
    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return User
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set psw
     *
     * @param string $psw
     *
     * @return User
     */
    public function setPsw($psw)
    {
        $this->psw = sha1($psw);
    }

    /**
     * Get psw
     *
     * @return string
     */
    public function getPsw()
    {
        return $this->psw;
    }

    /**
     * Set psw
     *
     * @param string $RepeatPsw
     *
     * @return User
     */
    public function setRepeatPsw($RepeatPsw)
    {
        $this->repeatPsw = sha1($RepeatPsw);
    }

    /**
     * Get psw
     *
     * @return string
     */
    public function getRepeatPsw()
    {
        return $this->repeatPsw;
    }

    /**
     * @return boolean True if equal
     */
    public function equalsPsw()
    {        
        return $this->psw == $this->repeatPsw;
    }    
    

}
