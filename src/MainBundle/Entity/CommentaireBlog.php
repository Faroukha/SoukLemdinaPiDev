<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CommentaireBlog
 *
 * @ORM\Table(name="commentaire_blog")
 * @ORM\Entity(repositoryClass="MainBundle\Repository\CommentaireBlogRepository")
 */
class CommentaireBlog
{

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateCom", type="date")
     */
    private $dateCom;

    /**
     * @ORM\ManyToOne(targetEntity="MainBundle\Entity\Blog")
     * @ORM\JoinColumn(name="idBlog", referencedColumnName="id")
     */
    private $idBlog;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     * @ORM\JoinColumn(name="idUser", referencedColumnName="id")
     */
    private $idUser;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;


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
     * Set description
     *
     * @param string $description
     *
     * @return CommentaireBlog
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

    /**
     * Set idBlog
     *
     * @param \MainBundle\Entity\Blog $idBlog
     *
     * @return CommentaireBlog
     */
    public function setIdBlog(\MainBundle\Entity\Blog $idBlog = null)
    {
        $this->idBlog = $idBlog;

        return $this;
    }

    /**
     * Get idBlog
     *
     * @return \MainBundle\Entity\Blog
     */
    public function getIdBlog()
    {
        return $this->idBlog;
    }

    /**
     * Set idUser
     *
     * @param \UserBundle\Entity\User $idUser
     *
     * @return CommentaireBlog
     */
    public function setIdUser(\UserBundle\Entity\User $idUser = null)
    {
        $this->idUser = $idUser;

        return $this;
    }

    /**
     * Get idUser
     *
     * @return \UserBundle\Entity\User
     */
    public function getIdUser()
    {
        return $this->idUser;
    }
    public function __construct()
    {
        $this->dateCom = new \DateTime();
    }

    /**
     * Set dateCom
     *
     * @param \DateTime $dateCom
     *
     * @return CommentaireBlog
     */
    public function setDateCom($dateCom)
    {
        $this->dateCom = $dateCom;

        return $this;
    }

    /**
     * Get dateCom
     *
     * @return \DateTime
     */
    public function getDateCom()
    {
        return $this->dateCom;
    }
}
