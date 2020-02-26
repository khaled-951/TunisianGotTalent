<?php

namespace FOSBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Mgilet\NotificationBundle\Annotation\Notifiable;
use Mgilet\NotificationBundle\NotifiableInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 * @Notifiable(name="fos_user")
 */
class User extends BaseUser implements NotifiableInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="facebook_id", type="string", nullable=true)
     */
    protected $facebookID;

    /**
     * @var string
     *
     * @ORM\Column(name="typec", type="string", length=255)
     */
    private $typec;

    /**
     * @var int
     *
     * @ORM\Column(name="nb_diamants", type="integer" , options={"default" : 0})
     */
    private $nbDiamants=0;

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

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }

    /**
     * @return string
     */
    public function getFacebookID()
    {
        return $this->facebookID;
    }

    /**
     * @param string $facebookID
     */
    public function setFacebookID($facebookID)
    {
        $this->facebookID = $facebookID;
    }

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



}
