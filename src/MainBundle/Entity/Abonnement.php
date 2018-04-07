<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Abonnement
 *
 * @ORM\Table(name="abonnement")
 * @ORM\Entity
 */
class Abonnement
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;


    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     * @ORM\JoinColumn(name="idmembre", referencedColumnName="id")
     */
    private $idmembre;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     * @ORM\JoinColumn(name="idartisan", referencedColumnName="id")
     */
    private $idartisan;



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
     * Set idmembre
     *
     * @param \UserBundle\Entity\User $idmembre
     *
     * @return Abonnement
     */
    public function setIdmembre(\UserBundle\Entity\User $idmembre = null)
    {
        $this->idmembre = $idmembre;

        return $this;
    }

    /**
     * Get idmembre
     *
     * @return \UserBundle\Entity\User
     */
    public function getIdmembre()
    {
        return $this->idmembre;
    }

    /**
     * Set idartisan
     *
     * @param \UserBundle\Entity\User $idartisan
     *
     * @return Abonnement
     */
    public function setIdartisan(\UserBundle\Entity\User $idartisan = null)
    {
        $this->idartisan = $idartisan;

        return $this;
    }

    /**
     * Get idartisan
     *
     * @return \UserBundle\Entity\User
     */
    public function getIdartisan()
    {
        return $this->idartisan;
    }
}
