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
     * @var integer
     *
     * @ORM\Column(name="idMembre", type="integer", nullable=false)
     */
    private $idmembre;

    /**
     * @var integer
     *
     * @ORM\Column(name="idArtisan", type="integer", nullable=false)
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
     * @param integer $idmembre
     *
     * @return Abonnement
     */
    public function setIdmembre($idmembre)
    {
        $this->idmembre = $idmembre;

        return $this;
    }

    /**
     * Get idmembre
     *
     * @return integer
     */
    public function getIdmembre()
    {
        return $this->idmembre;
    }

    /**
     * Set idartisan
     *
     * @param integer $idartisan
     *
     * @return Abonnement
     */
    public function setIdartisan($idartisan)
    {
        $this->idartisan = $idartisan;

        return $this;
    }

    /**
     * Get idartisan
     *
     * @return integer
     */
    public function getIdartisan()
    {
        return $this->idartisan;
    }
}
