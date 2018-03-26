<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Commentaire
 *
 * @ORM\Table(name="commentaire", indexes={@ORM\Index(name="idproduit", columns={"idproduit"})})
 * @ORM\Entity
 */
class Commentaire
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
     * @var string
     *
     * @ORM\Column(name="text", type="string", length=255, nullable=false)
     */
    private $text;

    /**
     * @var integer
     *
     * @ORM\Column(name="idproduit", type="integer", nullable=true)
     */
    private $idproduit;

    /**
     * @var string
     *
     * @ORM\Column(name="emailUser", type="string", length=20, nullable=false)
     */
    private $emailuser;



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
     * Set text
     *
     * @param string $text
     *
     * @return Commentaire
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set idproduit
     *
     * @param integer $idproduit
     *
     * @return Commentaire
     */
    public function setIdproduit($idproduit)
    {
        $this->idproduit = $idproduit;

        return $this;
    }

    /**
     * Get idproduit
     *
     * @return integer
     */
    public function getIdproduit()
    {
        return $this->idproduit;
    }

    /**
     * Set emailuser
     *
     * @param string $emailuser
     *
     * @return Commentaire
     */
    public function setEmailuser($emailuser)
    {
        $this->emailuser = $emailuser;

        return $this;
    }

    /**
     * Get emailuser
     *
     * @return string
     */
    public function getEmailuser()
    {
        return $this->emailuser;
    }
}
