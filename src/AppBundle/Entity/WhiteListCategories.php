<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * WhiteListCategories
 *
 * @ORM\Table(name="whitelist_categories")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\WhiteListCategoriesRepository")
 */
class WhiteListCategories
{


    /**
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param string $createdAt
     * @return Categories
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return string
     */
    public function getUpdateAt()
    {
        return $this->updateAt;
    }

    /**
     * @param string $updateAt
     * @return Categories
     */
    public function setUpdateAt($updateAt)
    {
        $this->updateAt = $updateAt;
        return $this;
    }

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     */
    private $id;


    /**
     * @var string
     *
     * @ORM\OneToOne(targetEntity="Pending" )
     * @ORM\JoinColumn(name="pending" ,  referencedColumnName="id", nullable=false)
     *
     *
     */
    private $pending;


    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @var string
     *
     * @ORM\Column(name="createdAt", type="datetime")
     */
    private $createdAt;

    /**
     * @var string
     *
     * @ORM\Column(name="updateAt", type="datetime")
     */
    private $updateAt;

}
