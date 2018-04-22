<?php

namespace ProduitBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Avis
 *
 * @ORM\Table(name="avis")
 * @ORM\Entity(repositoryClass="ProduitBundle\Repository\AvisRepository")
 */
class Avis
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="rating", type="integer", nullable=true)
     */
    private $rating;

    /**
     * @var int
     *
     * @ORM\Column(name="idE", type="integer", nullable=true)
     */
    private $idE;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set rating
     *
     * @param integer $rating
     *
     * @return Avis
     */
    public function setRating($rating)
    {
        $this->rating = $rating;

        return $this;
    }

    /**
     * Get rating
     *
     * @return int
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * Set idE
     *
     * @param integer $idE
     *
     * @return Avis
     */
    public function setIdE($idE)
    {
        $this->idE = $idE;

        return $this;
    }

    public function __toString()
    {
        return (String)$this->rating;
    }

    /**
     * Get idE
     *
     * @return int
     */
    public function getIdE()
    {
        return $this->idE;
    }

   /* public function __toString() {
        return $this->rating;
    }*/

}


