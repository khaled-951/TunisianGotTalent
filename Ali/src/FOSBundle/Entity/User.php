<?php

namespace FOSBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }
    /**
     * @var string
     *
     * @ORM\Column(name="typec", type="string", length=255)
     */
    private $typec;

    /**
     * @return int
     */
    public function getNbDiamants()
    {
        return $this->nbDiamants;
    }

    /**
     * @param int $nbDiamants
     */
    public function setNbDiamants($nbDiamants)
    {
        $this->nbDiamants = $nbDiamants;
    }
    /**
     * @var int
     *
     * @ORM\Column(name="nb_diamants", type="integer" , options={"default" : 0})
     */
    private $nbDiamants;

    /**
     * @return string
     */
    public function getTypec()
    {
        return $this->typec;
    }

    /**
     * @param string $typec
     */
    public function setTypec($typec)
    {
        $this->typec = $typec;
    }



    public function __construct()
    {
        parent::__construct();
        // your own logic
    }
}
