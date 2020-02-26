<?php

namespace ReclamationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * type
 *
 * @ORM\Table(name="type")
 * @ORM\Entity(repositoryClass="ReclamationBundle\Repository\typeRepository")
 */
class type
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
     * @ORM\Column(name="probleme", type="string", length=255)
     */
    private $probleme;


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
     * Set probleme
     *
     * @param string $probleme
     *
     * @return type
     */
    public function setProbleme($probleme)
    {
        $this->probleme = $probleme;

        return $this;
    }

    /**
     * Get probleme
     *
     * @return string
     */
    public function getProbleme()
    {
        return $this->probleme;
    }
    public function __toString()
    {
        return $this->probleme;
    }
}

