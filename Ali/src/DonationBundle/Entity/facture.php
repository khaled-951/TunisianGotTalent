<?php

namespace DonationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * facture
 *
 * @ORM\Table(name="facture")
 * @ORM\Entity(repositoryClass="DonationBundle\Repository\factureRepository")
 */
class facture
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
     * @return mixed
     */
    public function getDonationid()
    {
        return $this->donationid;
    }

    /**
     * @param mixed $donationid
     */
    public function setDonationid($donationid)
    {
        $this->donationid = $donationid;
    }
    /**
     * @ORM\ManyToOne(targetEntity="FOSBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id",referencedColumnName="id")
     */
    private $userid;

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
     * @ORM\ManyToOne(targetEntity="donation")
     * @ORM\JoinColumn(name="donation_id",referencedColumnName="id")
     */
    private $donationid;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_cr", type="date")
     */
    private $dateCr;


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
     * Set dateCr
     *
     * @param \DateTime $dateCr
     *
     * @return facture
     */
    public function setDateCr($dateCr)
    {
        $this->dateCr = $dateCr;

        return $this;
    }

    /**
     * Get dateCr
     *
     * @return \DateTime
     */
    public function getDateCr()
    {
        return $this->dateCr;
    }
}

