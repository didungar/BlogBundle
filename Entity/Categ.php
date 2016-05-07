<?php

namespace DidUngar\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Categ
 *
 * @ORM\Table(name="blog_categ")
 * @ORM\Entity(repositoryClass="DidUngar\BlogBundle\Entity\CategRepository")
 */
class Categ
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
     * @var integer
     *
     * @ORM\Column(name="id_blog", type="integer")
     */
    private $idBlog;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=35)
     */
    private $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=35)
     */
    private $title;


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
     * Set idBlog
     *
     * @param integer $idBlog
     *
     * @return Categ
     */
    public function setIdBlog($idBlog)
    {
        $this->idBlog = $idBlog;

        return $this;
    }

    /**
     * Get idBlog
     *
     * @return integer
     */
    public function getIdBlog()
    {
        return $this->idBlog;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Categ
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Categ
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }
}

