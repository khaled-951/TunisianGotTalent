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
     * @ORM\Id
     * @ORM\Column(name="nb_diamants", type="integer")
     */
    private $nbDiamants;





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

}

