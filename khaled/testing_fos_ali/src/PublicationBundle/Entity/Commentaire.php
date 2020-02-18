<?php

namespace PublicationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Commentaire
 *
 * @ORM\Table(name="commentaire")
 * @ORM\Entity(repositoryClass="PublicationBundle\Repository\CommentaireRepository")
 */
class Commentaire
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
     * @var string
     *
     * @ORM\Column(name="Commentaire", type="string", length=255)
     */
    private $commentaire;

    /**
     * @ORM\ManyToOne(targetEntity="Publication")
     * @ORM\JoinColumn(name="Publication_id",referencedColumnName="id")
     */
    private $Publication_id;

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
     * @return mixed
     */
    public function getPublicationId()
    {
        return $this->Publication_id;
    }

    /**
     * @param mixed $Publication_id
     */
    public function setPublicationId($Publication_id)
    {
        $this->Publication_id = $Publication_id;
    }

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateCommentaire", type="datetime", options={"default": "CURRENT_TIMESTAMP"})
     */
    private $dateCommentaire;


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
     * Set commentaire
     *
     * @param string $commentaire
     *
     * @return Commentaire
     */
    public function setCommentaire($commentaire)
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    /**
     * Get commentaire
     *
     * @return string
     */
    public function getCommentaire()
    {
        return $this->commentaire;
    }

    /**
     * Set dateCommentaire
     *
     * @param \DateTime $dateCommentaire
     *
     * @return Commentaire
     */
    public function setDateCommentaire($dateCommentaire)
    {
        $this->dateCommentaire = $dateCommentaire;

        return $this;
    }

    /**
     * Get dateCommentaire
     *
     * @return \DateTime
     */
    public function getDateCommentaire()
    {
        return $this->dateCommentaire;
    }
}

