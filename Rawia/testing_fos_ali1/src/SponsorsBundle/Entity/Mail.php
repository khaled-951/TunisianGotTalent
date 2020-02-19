<?php

namespace SponsorsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Mail
 *
 * @ORM\Table(name="mail")
 * @ORM\Entity(repositoryClass="SponsorsBundle\Repository\MailRepository")
 */
class Mail
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
     * @ORM\Column(name="mailto", type="string", length=255)
     */
    private $mailto;

    /**
     * @var string
     *
     * @ORM\Column(name="subject", type="string", length=255)
     */
    private $subject;

    /**
     * @var string
     *
     * @ORM\Column(name="object", type="string", length=255)
     */
    private $object;

    /**
     * @var string
     *
     * @ORM\Column(name="mailfrom", type="string", length=255)
     */

    private $mailfrom;

    /**
     * @return \DateTime
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * @param \DateTime $time
     */
    public function setTime($time)
    {
        $this->time = $time;
    }
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="time", type="datetime", length=255)
     */
    private $time;

    /**
     *@var integer
     *
     * @ORM\ManyToOne(targetEntity="Sponsor")
     * @ORM\JoinColumn(name="idsp", referencedColumnName="idsp")
     */
    private $idsp;


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
     * Set mailto
     *
     * @param string $mailto
     *
     * @return Mail
     */
    public function setMailto($mailto)
    {
        $this->mailto = $mailto;

        return $this;
    }

    /**
     * Get mailto
     *
     * @return string
     */
    public function getMailto()
    {
        return $this->mailto;
    }

    /**
     * Set subject
     *
     * @param string $subject
     *
     * @return Mail
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set object
     *
     * @param string $object
     *
     * @return Mail
     */
    public function setObject($object)
    {
        $this->object = $object;

        return $this;
    }

    /**
     * Get object
     *
     * @return string
     */
    public function getObject()
    {
        return $this->object;
    }

    /**
     * @return string
     */
    public function getMailfrom()
    {
        return $this->mailfrom;
    }

    /**
     * @param string $mailfrom
     */
    public function setMailfrom($mailfrom)
    {
        $this->mailfrom = $mailfrom;
    }

    /**
     * @return int
     */
    public function getIdsp()
    {
        return $this->idsp;
    }

    /**
     * @param integer $idsp
     */
    public function setIdsp($idsp)
    {
        $this->idsp = $idsp;
    }

}

