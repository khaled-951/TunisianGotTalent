<?php

namespace FOSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * chasseurtalent
 *
 * @ORM\Table(name="chasseurtalent")
 * @ORM\Entity(repositoryClass="FOSBundle\Repository\chasseurtalentRepository")
 */
class chasseurtalent
{


    /**
     * @var string
     *
     * @ORM\Column(name="profession", type="string", length=255)
     */
    private $profession;

    /**
     * @return mixed
     */
    public function getUserid()
    {
        return $this->userid;
    }

    /**
     * @param mixed $userid
     */
    public function setUserid($userid)
    {
        $this->userid = $userid;
    }
    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id",referencedColumnName="id")
     */
    private $userid;
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(name="cin", type="bigint")
     */
    private $cin;


    /**
     * Set profession
     *
     * @param string $profession
     *
     * @return chasseurtalent
     */
    public function setProfession($profession)
    {
        $this->profession = $profession;

        return $this;
    }

    /**
     * Get profession
     *
     * @return string
     */
    public function getProfession()
    {
        return $this->profession;
    }

    /**
     * Set cin
     *
     * @param integer $cin
     *
     * @return chasseurtalent
     */
    public function setCin($cin)
    {
        $this->cin = $cin;

        return $this;
    }

    /**
     * Get cin
     *
     * @return int
     */
    public function getCin()
    {
        return $this->cin;
    }
}

