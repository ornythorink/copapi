<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * Products
 *
 * @ORM\Table(  name="products", indexes={
 *      @ORM\Index(name="status_idx", columns={"status"}) ,
 *      @ORM\Index(name="api_id_idx", columns={"id_api"}) ,
 *      }  )
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProductsRepository")
 * @UniqueEntity("short_url")
 */
class Products
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="id_api", type="string", nullable=true ,  length=255)
     *
     */
    private $id_api;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="ean", type="string", length=255)
     */
    private $ean;


    /**
     * @var string
     *
     * @ORM\Column(name="price", type="decimal", scale=2)
     */
    private $price;

    /**
     * @var string
     *
     * @ORM\Column(name="currency", type="string")
     */
    private $currency;


    /**
     * @var integer
     *
     * @ORM\Column(name="site_id", type="integer")
     */
    private $siteId;


    /**
     * @var string
     *
     * @ORM\Column(name="logostore", type="string", nullable=true)
     */
    private $logostore;

    /**
     * @var string
     *
     * @ORM\Column(name="promo", nullable=TRUE, type="decimal", scale=2)
     */
    private $promo;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=50)
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="brand", type="string", nullable=true, length=255)
     */
    private $brand;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="text")
     */
    private $image;


    /**
     * @var integer
     *
     * @ORM\Column(name="source_id", type="string")
     */
    private $sourceId;

    /**
     * @var string
     *
     * @ORM\Column(name="source_type", type="string")
     */
    private $sourceType;

    /**
     * @var string
     *
     * @ORM\Column(name="program", type="string", nullable=true, length=255)
     */
    private $program;

    /**
     * @var string
     *
     * @ORM\Column(name="actif", type="string", nullable=true, length=1)
     */
    private $actif;

    /**
     * @var string
     *
     * @ORM\Column(name="locale", type="string", length=2)
     */
    private $locale;

    /**
     * @var string
     *
     * @ORM\Column(name="category_merchant",nullable=true, type="string", length=255)
     */
    private $categoryMerchant;

    /**
     * @var string
     *
     * @ORM\Column(name="softdeleted", type="string", length=1 , nullable=true,  options={"default":"N"})  )
     */
    private $softdeleted;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updateAt", type="datetime")
     */
    private $updateAt;

    /**
     * @var string
     *
     * @ORM\Column(name="description", nullable=true , type="string", length=255)
     */
    private $description;

    /**
     * @var text
     *
     * @ORM\Column(name="url", type="text", length=400))
     */
    private $url;

    /**
     * @var text
     *
     * @ORM\Column(name="short_url", type="string", length=32,  unique=true)
     */
    private $short_url;

    /**
     * @var text
     *
     */
    private $relevance;


    /**
     * @return text
     */
    public function getRelevance()
    {
        return $this->relevance;
    }


    /**
     * @param text $relevance
     */
    public function setRelevance($relevance)
    {
        $this->relevance = $relevance;
    }

    /**
     * @return mixed
     */
    public function getShortUrl()
    {
        return $this->short_url;
    }

    /**
     * @param mixed $short_url
     */
    public function setShortUrl($short_url)
    {
        $this->short_url = md5($short_url);
    }

    private $offers;

    /**
     * @return mixed
     */
    public function getOffers()
    {
        return $this->offers;
    }

    /**
     * @param mixed $offers
     */
    public function setOffers($offer)
    {
        $this->offers[] = $offer;
    }


    public function createFromArray($data)
    {
        $createdAt = new \DateTime($data["created_at"]);
        $updatedAt = new \DateTime($data["update_at"]);

        $this->setName($data["name"]);
        $this->setPrice($data["price"]);
        $this->setCurrency($data["currency"]);
        $this->setSiteId($data["site_id"]);
        $this->setLogostore($data["logostore"]);
        $this->setStatus($data["status"]);
        $this->setBrand($data["brand"]);
        $this->setImage($data["image"]);
        $this->setSourceId($data["source_id"]);
        $this->setSourceType($data["source_type"]);
        $this->setProgram($data["program"]);
        $this->setLocale($data["locale"]);
        $this->setCategoryMerchant($data["category_merchant"]);
        $this->setCreatedAt($createdAt);
        $this->setUpdateAt($updatedAt);
        $this->setDescription($data["description"]);
        $this->setUrl($data["url"]);
        $this->setShortUrl($data["short_url"]);
    }

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
     * @return Products
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getSourceType()
    {
        return $this->sourceType;
    }

    /**
     * @param string $sourceType
     */
    public function setSourceType($sourceType)
    {
        $this->sourceType = $sourceType;
    }


    /**
     * @return string
     */
    public function getIdApi()
    {
        return $this->id_api;
    }

    /**
     * @param string $id_api
     */
    public function setIdApi($id_api)
    {
        $this->id_api = $id_api;
    }




    /**
     * Set name
     *
     * @param string $name
     * @return Products
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }


    /**
     * @return string
     */
    public function getEan()
    {
        return $this->ean;
    }

    /**
     * @param string $ean
     */
    public function setEan($ean)
    {
        $this->ean = $ean;
    }


    /**
     * @return mixed
     */
    public function getLogostore()
    {
        return $this->logostore;
    }

    /**
     * @param mixed $logostore
     */
    public function setLogostore($logostore)
    {
        if($logostore !== null)
        {
            $this->logostore = $logostore;
        }
    }

    /**
     * Get url
     *
     * @return text 
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set url
     *
     * @param string $name
     * @return Products
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }


    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        
        return  $this->name;
    }

    /**
     * Set price
     *
     * @param string $price
     * @return Products
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string 
     */
    public function getPrice()
    {
        return $this->price;
    }

   /**
     * Set currency
     *
     * @param string $currency
     * @return Products
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * Get currency
     *
     * @return string 
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * Set siteId
     *
     * @param integer $siteId
     * @return Products
     */
    public function setSiteId($siteId)
    {
        $this->siteId = $siteId;

        return $this;
    }

    /**
     * Get siteId
     *
     * @return integer 
     */
    public function getSiteId()
    {
        return $this->siteId;
    }

    /**
     * Set promo
     *
     * @param string $promo
     * @return Products
     */
    public function setPromo($promo)
    {
        $this->promo = $promo;

        return $this;
    }

    /**
     * Get promo
     *
     * @return string 
     */
    public function getPromo()
    {
        return $this->promo;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return Products
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set brand
     *
     * @param string $brand
     * @return Products
     */
    public function setBrand($brand)
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * Get brand
     *
     * @return string 
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * Set image
     *
     * @param string $image
     * @return Products
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string 
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set sourceId
     *
     * @param integer $sourceId
     * @return Products
     */
    public function setSourceId($sourceId)
    {
        $this->sourceId = $sourceId;

        return $this;
    }

    /**
     * Get sourceId
     *
     * @return integer 
     */
    public function getSourceId()
    {
        return $this->sourceId;
    }

    /**
     * Set program
     *
     * @param string $program
     * @return Products
     */
    public function setProgram($program)
    {
        $this->program = $program;

        return $this;
    }

    /**
     * Get program
     *
     * @return string 
     */
    public function getProgram()
    {
        return $this->program;
    }

    /**
     * Set actif
     *
     * @param string $actif
     * @return Products
     */
    public function setActif($actif)
    {
        $this->actif = $actif;

        return $this;
    }

    /**
     * Get actif
     *
     * @return string 
     */
    public function getActif()
    {
        return $this->actif;
    }

    /**
     * Set locale
     *
     * @param string $locale
     * @return Products
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;

        return $this;
    }

    /**
     * Get locale
     *
     * @return string 
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * Set categoryMerchant
     *
     * @param string $categoryMerchant
     * @return Products
     */
    public function setCategoryMerchant($categoryMerchant)
    {
        $this->categoryMerchant = $categoryMerchant;

        return $this;
    }

    /**
     * Get categoryMerchant
     *
     * @return string 
     */
    public function getCategoryMerchant()
    {
        return $this->categoryMerchant;
    }


    /**
     * Set softdeleted
     *
     * @param string $softdeleted
     * @return Products
     */
    public function setSoftdeleted($softdeleted)
    {
        $this->softdeleted = $softdeleted;

        return $this;
    }

    /**
     * Get softdeleted
     *
     * @return string 
     */
    public function getSoftdeleted()
    {
        return $this->softdeleted;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Products
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updateAt
     *
     * @param \DateTime $updateAt
     * @return Products
     */
    public function setUpdateAt($updateAt)
    {
        $this->updateAt = $updateAt;

        return $this;
    }

    /**
     * Get updateAt
     *
     * @return \DateTime 
     */
    public function getUpdateAt()
    {
        return $this->updateAt;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Products
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }
}
