<?php

namespace FOSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * talent
 *
 * @ORM\Table(name="talent")
 * @ORM\Entity(repositoryClass="FOSBundle\Repository\talentRepository")
 */
class talent
{

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id",referencedColumnName="id")
     */
    private $userid;
    /**
     * @var int
     *
     * @ORM\Column(name="nb_diamants", type="integer")
     */
    private $nbDiamants;

    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(name="age", type="integer")
     */
    private $age;

    /**
     *
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255 , columnDefinition="ENUM('chommeur ', 'etudiant ' , 'employee')")
     */
    private $status;

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
     * Set nbDiamants
     *
     * @param integer $nbDiamants
     *
     * @return talent
     */
    public function setNbDiamants($nbDiamants)
    {
        $this->nbDiamants = $nbDiamants;

        return $this;
    }

    /**
     * Get nbDiamants
     *
     * @return int
     */
    public function getNbDiamants()
    {
        return $this->nbDiamants;
    }

    /**
     * Set age
     *
     * @param integer $age
     *
     * @return talent
     */
    public function setAge($age)
    {
        $this->age = $age;

        return $this;
    }

    /**
     * Get age
     *
     * @return int
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return talent
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }
}

