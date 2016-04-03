<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Pending
 *
 * @ORM\Table(name="pending" )}  )
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PendingRepository")
 */
class Pending
{

    /**
     * @var string
     * @ORM\Id
     * @ORM\Column(name="id", type="string")
     * @ORM\OneToOne(targetEntity="WhiteListCategories", mappedBy="pending")
     */
    private $id;



    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdat", type="datetime")
     */
    private $createdat;

    /**
     * @var string
     *
     * @ORM\Column(name="label", type="string")
     */
    private $label;

    /**
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }



    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param string $label
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }

    /**
     * Set createdat
     *
     * @param \DateTime $createdat
     * @return Pending
     */
    public function setCreatedat($createdat)
    {
        $this->createdat = $createdat;

        return $this;
    }

    /**
     * Get createdat
     *
     * @return \DateTime 
     */
    public function getCreatedat()
    {
        return $this->createdat;
    }


}
