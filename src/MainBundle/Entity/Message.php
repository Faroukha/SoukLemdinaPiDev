<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Message
 *
 * @ORM\Table(name="message")
 * @ORM\Entity(repositoryClass="MainBundle\Repository\MessageRepository")
 */
class Message
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
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     * @ORM\JoinColumn(name="idRes", referencedColumnName="id")
     */
    private $idRes;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     * @ORM\JoinColumn(name="idEnv", referencedColumnName="id")
     */
    private $idEnv;

    /**
     * @var string
     *
     * @ORM\Column(name="contenu", type="text")
     */
    private $contenu;


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
     * Set contenu
     *
     * @param string $contenu
     *
     * @return Message
     */
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;

        return $this;
    }

    /**
     * Get contenu
     *
     * @return string
     */
    public function getContenu()
    {
        return $this->contenu;
    }

    /**
     * Set idRes
     *
     * @param \UserBundle\Entity\User $idRes
     *
     * @return Message
     */
    public function setIdRes(\UserBundle\Entity\User $idRes = null)
    {
        $this->idRes = $idRes;

        return $this;
    }

    /**
     * Get idRes
     *
     * @return \UserBundle\Entity\User
     */
    public function getIdRes()
    {
        return $this->idRes;
    }

    /**
     * Set idEnv
     *
     * @param \UserBundle\Entity\User $idEnv
     *
     * @return Message
     */
    public function setIdEnv(\UserBundle\Entity\User $idEnv = null)
    {
        $this->idEnv = $idEnv;

        return $this;
    }

    /**
     * Get idEnv
     *
     * @return \UserBundle\Entity\User
     */
    public function getIdEnv()
    {
        return $this->idEnv;
    }
}
