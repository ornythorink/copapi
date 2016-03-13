<?php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\VirtualProperty;

/**
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 *
 * @ExclusionPolicy("all")
 */
class User extends BaseUser
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Expose
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     * @Expose
     */
    protected $name;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     * @Expose
     */
    protected $firstname;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param mixed $firstname
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }


    /**
     * Get the formatted name to display (NAME Firstname or username)
     *
     * @param $separator : the separator between name and firstname (default: ' ')
     * @return String
     * @VirtualProperty
     */
    public function getUsedName($separator = ' ')
    {
        if ($this->getName() != null && $this->getFirstName() != null) {
            return ucfirst(strtolower($this->getFirstName())) . $separator . strtoupper($this->getName());
        } else {
            return $this->getUsername();
        }
    }
}