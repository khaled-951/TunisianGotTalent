<?php

namespace PublicationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Views
 *
 * @ORM\Table(name="views")
 * @ORM\Entity(repositoryClass="PublicationBundle\Repository\ViewsRepository")
 */
class Views
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
     * @ORM\ManyToOne(targetEntity="\FOSBundle\Entity\User")
     * @ORM\JoinColumn(name="userId",referencedColumnName="id", nullable=false)
     */
    private $userId;

    /**
     * @ORM\ManyToOne(targetEntity="Publication")
     * @ORM\JoinColumn(name="Publication_id",referencedColumnName="id")
     */
    private $Publication_id;


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
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param mixed $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
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


}

