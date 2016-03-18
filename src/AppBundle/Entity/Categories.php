<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;



/**
 * Categories
 *
 * @ORM\Table( name="categories", indexes={@ORM\Index(name="parent_idx", columns={"id_parent"})} ,     uniqueConstraints={@ORM\UniqueConstraint(name="categoryslug2_idx", columns={"categoryslug"})}  )
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CategoriesRepository")
*/
class Categories
{
    /**
     * @var integer

     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name_categorie", type="string", length=255, nullable=false)
     */
    private $nameCategorie;

    /**
     * @var string
     *
     * @ORM\Column(name="tag", type="string", length=255, nullable=true)
     */
    private $tag;

    /**
     * @var string
     *
     * @ORM\Column(name="term", type="string", length=255, nullable=true)
     */
    private $term;

    /**
     * @var string
     *
     * @ORM\Column(name="categoryslug", type="string", length=255, nullable=false)
     */
    private $categoryslug;


    /**
     * @var boolean
     *
     * @ORM\Column(name="actif", type="boolean", nullable=false)
     */
    private $actif;

    /**
     * @var boolean
     *
     * @ORM\Column(name="order", type="boolean", nullable=false)
     */
    private $order;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_parent", type="smallint", nullable=false)
     */
    private $idParent;



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
     * Set nameCategorie
     *
     * @param string $nameCategorie
     * @return Categories
     */
    public function setNameCategorie($nameCategorie)
    {
        $this->nameCategorie = $nameCategorie;

        return $this;
    }

    /**
     * Get nameCategorie
     *
     * @return string 
     */
    public function getNameCategorie()
    {
        return $this->nameCategorie;
    }

    /**
     * Set tag
     *
     * @param string $tag
     * @return Categories
     */
    public function setTag($tag)
    {
        $this->tag = $tag;

        return $this;
    }

    /**
     * Get tag
     *
     * @return string 
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * Set categoryslug
     *
     * @param string $categoryslug
     * @return Categories
     */
    public function setCategorySlug($categoryslug)
    {
        $this->categoryslug = $categoryslug;

        return $this;
    }

    /**
     * Get categorieslug
     *
     * @return string
     */
    public function getCategorySlug()
    {
        return $this->categoryslug;
    }


    /**
     * Set actif
     *
     * @param boolean $actif
     * @return Categories
     */
    public function setActif($actif)
    {
        $this->actif = $actif;

        return $this;
    }

    /**
     * Get actif
     *
     * @return boolean 
     */
    public function getActif()
    {
        return $this->actif;
    }

    /**
     * Set order
     *
     * @param boolean $order
     * @return Categories
     */
    public function setOrder($order)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Get order
     *
     * @return boolean 
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Set term
     *
     * @param string $term
     * @return Categories
     */
    public function setTerm($term)
    {
        $this->term = $term;

        return $this;
    }

    /**
     * Get term
     *
     * @return string
     */
    public function getTerm()
    {
        return $this->term;
    }

    /**
     * Set idParent
     *
     * @param integer $idParent
     * @return Categories
     */
    public function setIdParent($idParent)
    {
        $this->idParent = $idParent;

        return $this;
    }

    /**
     * Get idParent
     *
     * @return integer 
     */
    public function getIdParent()
    {
        return $this->idParent;
    }
}
