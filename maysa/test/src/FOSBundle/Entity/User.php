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
     * @var string
     *
     * @ORM\Column(name="typec", type="string", length=255)
     */
    private $typec;

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
}
