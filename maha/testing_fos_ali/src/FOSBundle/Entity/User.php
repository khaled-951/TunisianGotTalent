<?php

namespace FOSBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use GroupeBundle\Entity\Groupe;

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

   // un utilisateur a plusieurs groupes
    /**
     * @ORM\OneToMany(targetEntity="GroupeBundle\Entity\Groupe",mappedBy="groupe")
     */
    private $groupes;

    public function addgroupe(Groupe $groupe)
    {

        // for a many-to-one association:
      //  $groupe->setUser($this);

        $this->groupes->add($groupe);
    }
    /**
     * @return ArrayCollection
     */
    public function getGroupes()
    {
        return $this->groupes;
    }

    /**
     * @param ArrayCollection $groupes
     */
    public function setGroupes($groupes)
    {
        $this->groupes = $groupes;
    }

    public function __construct()
    {
        parent::__construct();
        $this->groupes=new ArrayCollection();
    }
}
