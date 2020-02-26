<?php

namespace SponsorsBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Sponsor
 *
 * @ORM\Table(name="sponsor")
 * @ORM\Entity(repositoryClass="SponsorsBundle\Repository\SponsorRepository")
 */
class Sponsor
{
    /**
     * @var int
     *
     * @ORM\Column(name="idsp", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idsp;

    /**
     * @var string
     *
     * @ORM\Column(name="namesp", type="string", length=255)
     * @Assert\NotBlank(message="Field cannot be empty!")
     */
    private $namesp;

    /**
     * @var string
     * @ORM\Column(name="address", type="string", length=255)
     *@Assert\NotBlank(message="Field cannot be empty!")
     *
     *
     */
    private $address;

    /**
     * @var string
     * @ORM\Column(name="email", type="string", length=255)
     *@Assert\NotBlank(message="Field cannot be empty!")
     * @Assert\Email(message="this does not match the email pattern!")
     *
     */
    private $email;

    /**
     * @var string
     *@ORM\Column(name="tel", type="string", length=255)
     * @Assert\NotBlank(message="Field cannot be empty!")
     * @Assert\Length(max=8)
     *
     */
    private $tel;

    /**
     * @var string
     *@
     * @ORM\Column(name="description", type="string", length=255)
     * @Assert\NotBlank(message="Field cannot be empty!")
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="logo", type="string", length=255)
     * @Assert\NotBlank(message="Field cannot be empty!")
     */
    private $logo;


    /**
     * Get idsp
     *
     * @return int
     */
    public function getIdsp()
    {
        return $this->idsp;
    }





    /**
     * Set namesp
     *
     * @param string $namesp
     *
     * @return Sponsor
     */
    public function setNamesp($namesp)
    {
        $this->namesp = $namesp;

        return $this;
    }

    /**
     * Get namesp
     *
     * @return string
     */
    public function getNamesp()
    {
        return $this->namesp;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return Sponsor
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Sponsor
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set tel
     *
     * @param string $tel
     *
     * @return Sponsor
     */
    public function setTel($tel)
    {
        $this->tel = $tel;

        return $this;
    }

    /**
     * Get tel
     *
     * @return string
     */
    public function getTel()
    {
        return $this->tel;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Sponsor
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set logo
     *
     * @param string $logo
     *
     * @return Sponsor
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;

        return $this;
    }

    /**
     * Get logo
     *
     * @return string
     */
    public function getLogo()
    {
        return $this->logo;
    }
}

