<?php

namespace SponsorsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Pack
 *
 * @ORM\Table(name="pack")
 * @ORM\Entity(repositoryClass="SponsorsBundle\Repository\PackRepository")
 */
class Pack
{
    /**
     * @var int
     *
     * @ORM\Column(name="idad", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idad;



    /**
     * @var string
     *
     * @ORM\Column(name="position", type="string", length=255)
     */
    private $position;

    /**
     * @var string
     *
     * @ORM\Column(name="ad", type="string", length=255)
     */
    private $ad;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="displaydate", type="datetime")
     */
    private $displaydate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="discarddate", type="datetime")
     */
    private $discarddate;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="string", length=255)
     */
    private $price;

    /**
     *
     *
     * @ORM\ManyToOne(targetEntity="Sponsor")
     * @ORM\JoinColumn(name="idsp", referencedColumnName="idsp")
     */

    private $idsp;


    /**
     * Get idad
     *
     * @return int
     */
    public function getIdad()
    {
        return $this->idad;
    }



    /**
     * Set position
     *
     * @param string $position
     *
     * @return Pack
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return string
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set ad
     *
     * @param string $ad
     *
     * @return Pack
     */
    public function setAd($ad)
    {
        $this->ad = $ad;

        return $this;
    }

    /**
     * Get ad
     *
     * @return string
     */
    public function getAd()
    {
        return $this->ad;
    }

    /**
     * Set displaydate
     *
     * @param \DateTime $displaydate
     *
     * @return Pack
     */
    public function setDisplaydate($displaydate)
    {
        $this->displaydate = $displaydate;

        return $this;
    }

    /**
     * Get displaydate
     *
     * @return \DateTime
     */
    public function getDisplaydate()
    {
        return $this->displaydate;
    }

    /**
     * Set discarddate
     *
     * @param \DateTime $discarddate
     *
     * @return Pack
     */
    public function setDiscarddate($discarddate)
    {
        $this->discarddate = $discarddate;

        return $this;
    }

    /**
     * Get discarddate
     *
     * @return \DateTime
     */
    public function getDiscarddate()
    {
        return $this->discarddate;
    }

    /**
     * Set price
     *
     * @param string $price
     *
     * @return Pack
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set idsp
     *
     * @param integer $idsp
     *
     * @return Pack
     */
    public function setIdsp($idsp)
    {
        $this->idsp = $idsp;

        return $this;
    }

    /**
     * Get idsp
     *
     * @return int
     */
    public function getIdsp()
    {
        return $this->idsp;
    }
}

