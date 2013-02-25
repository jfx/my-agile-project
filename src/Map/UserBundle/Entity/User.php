<?php

namespace Map\UserBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="map_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=50)
     */
    protected $name;
    
    /**
     * @var string $firstname
     *
     * @ORM\Column(name="firstname", type="string", length=50)
     */
    protected $firstname;

    /**
     * @var string $displayname
     *
     * @ORM\Column(name="displayname", type="string", length=50, unique=true)
     */
    protected $displayname;
    
    /**
     * @var string $details
     *
     * @ORM\Column(name="details", type="text", nullable=true)
     */
    private $details;
    
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * Set name
     *
     * @param string $name
     * @return User
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
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
     * Set firstname
     *
     * @param string $firstname
     * @return User
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    
        return $this;
    }

    /**
     * Get firstname
     *
     * @return string 
     */
    public function getFirstname()
    {
        return $this->firstname;
    }
    
    /**
     * Set displayname
     *
     * @param string $displayname
     * @return User
     */
    public function setDisplayname($displayname)
    {
        $this->displayname = $displayname;
    
        return $this;
    }

    /**
     * Get displayname
     *
     * @return string 
     */
    public function getDisplayname()
    {
        return $this->displayname;
    }
    
    /**
     * Set details
     *
     * @param string $details
     * @return User
     */
    public function setDetails($details)
    {
        $this->details = $details;
    
        return $this;
    }

    /**
     * Get details
     *
     * @return string 
     */
    public function getDetails()
    {
        return $this->details;
    }
    
    /**
     * Set password
     *
     * @param string $password
     * @return User
     */
    public function setUpdatedPassword($password)
    {
        if (!empty($password)) {
            $this->setPlainPassword($password);
        }    
        return $this;
    }

    /**
     * Get an empty password
     *
     * @return string 
     */
    public function getUpdatedPassword()
    {
        return '';
    }
}