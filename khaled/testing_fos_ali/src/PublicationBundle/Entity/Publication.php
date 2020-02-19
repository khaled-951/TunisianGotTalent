<?php

namespace PublicationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Publication
 *
 * @ORM\Table(name="publication")
 * @ORM\Entity(repositoryClass="PublicationBundle\Repository\PublicationRepository")
 */
class Publication
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
     * @var \DateTime
     *
     * @ORM\Column(name="datePublication", type="datetime", options={"default": "CURRENT_TIMESTAMP"})
     */
    private $datePublication;

    /**
     * @return \DateTime
     */
    public function getDatePublication()
    {
        return $this->datePublication;
    }

    /**
     * @param \DateTime $datePublication
     */
    public function setDatePublication($datePublication)
    {
        $this->datePublication = $datePublication;
    }

    /**
     * @var string
     *
     * @ORM\Column(name="titrePublication", type="string", length=255)
     */
    private $titrePublication;

    /**
     * @var string
     *
     * @ORM\Column(name="typePublication", type="string", length=255)
     */
    private $typePublication;

    /**
     * @var string
     *
     * @ORM\Column(name="srcPublication", type="string", length=255)
     */
    private $srcPublication;

    /**
     * @var int
     *
     * @ORM\Column(name="likesPublication", type="integer", options={"default" : 0})
     */
    private $likesPublication;

    /**
     * @ORM\ManyToOne(targetEntity="\FOSBundle\Entity\User")
     * @ORM\JoinColumn(name="userIdPublication",referencedColumnName="id", nullable=false)
     */
    private $userIdPublication;

    /**
     * @return mixed
     */
    public function getUserIdPublication()
    {
        return $this->userIdPublication;
    }

    /**
     * @param mixed $userIdPublication
     */
    public function setUserIdPublication($userIdPublication)
    {
        $this->userIdPublication = $userIdPublication;
    }

    /**
     * @var int
     *
     * @ORM\Column(name="isVisiblePublication", type="integer", options={"default" : 1})
     */
    private $isVisiblePublication;

    /**
     * @return int
     */
    public function getIsVisiblePublication()
    {
        return $this->isVisiblePublication;
    }

    /**
     * @param int $isVisiblePublication
     */
    public function setIsVisiblePublication($isVisiblePublication)
    {
        $this->isVisiblePublication = $isVisiblePublication;
    }

    /**
     * @var string
     *
     * @ORM\Column(name="catPublication", type="string", length=255)
     */
    private $catPublication;

    /**
     * @var int
     *
     * @ORM\Column(name="viewsPublication", type="integer", options={"default" : 0})
     */
    private $viewsPublication;


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
     * Set titrePublication
     *
     * @param string $titrePublication
     *
     * @return Publication
     */
    public function setTitrePublication($titrePublication)
    {
        $this->titrePublication = $titrePublication;

        return $this;
    }

    /**
     * Get titrePublication
     *
     * @return string
     */
    public function getTitrePublication()
    {
        return $this->titrePublication;
    }

    /**
     * Set typePublication
     *
     * @param string $typePublication
     *
     * @return Publication
     */
    public function setTypePublication($typePublication)
    {
        $this->typePublication = $typePublication;

        return $this;
    }

    /**
     * Get typePublication
     *
     * @return string
     */
    public function getTypePublication()
    {
        return $this->typePublication;
    }

    /**
     * Set srcPublication
     *
     * @param string $srcPublication
     *
     * @return Publication
     */
    public function setSrcPublication($srcPublication)
    {
        $this->srcPublication = $srcPublication;

        return $this;
    }

    /**
     * Get srcPublication
     *
     * @return string
     */
    public function getSrcPublication()
    {
        return $this->srcPublication;
    }

    /**
     * Set likesPublication
     *
     * @param integer $likesPublication
     *
     * @return Publication
     */
    public function setLikesPublication($likesPublication)
    {
        $this->likesPublication = $likesPublication;

        return $this;
    }

    /**
     * Get likesPublication
     *
     * @return int
     */
    public function getLikesPublication()
    {
        return $this->likesPublication;
    }

    /**
     * Set catPublication
     *
     * @param string $catPublication
     *
     * @return Publication
     */
    public function setCatPublication($catPublication)
    {
        $this->catPublication = $catPublication;

        return $this;
    }

    /**
     * Get catPublication
     *
     * @return string
     */
    public function getCatPublication()
    {
        return $this->catPublication;
    }

    /**
     * Set viewsPublication
     *
     * @param string $viewsPublication
     *
     * @return Publication
     */
    public function setViewsPublication($viewsPublication)
    {
        $this->viewsPublication = $viewsPublication;

        return $this;
    }

    /**
     * Get viewsPublication
     *
     * @return string
     */
    public function getViewsPublication()
    {
        return $this->viewsPublication;
    }
}

