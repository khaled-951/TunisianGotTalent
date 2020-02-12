<?php

namespace DonationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * donation
 *
 * @ORM\Table(name="donation")
 * @ORM\Entity(repositoryClass="DonationBundle\Repository\donationRepository")
 */
class donation
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
     * @ORM\Column(name="lib_donation", type="string", length=255)
     */
    private $libDonation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_cr", type="date")
     */
    private $dateCr;

    /**
     * @var int
     *
     * @ORM\Column(name="valeur_d", type="integer")
     */
    private $valeurD;

    /**
     * @var string
     *
     * @ORM\Column(name="photo", type="string", length=255)
     */
    private $photo;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

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
     * @var string
     *
     * @ORM\Column(name="categorie", type="string", length=255)
     */
    private $categorie;

    /**
     * @return mixed
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param mixed $file
     */
    public function setFile($file)
    {
        $this->file = $file;
    }
    /**
     * @ORM\ManyToOne(targetEntity="FOSBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id",referencedColumnName="id")
     */
    private $userid;
    /**
     * @Assert\File(maxSize="6000000")
     */
    private $file;


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
     * Set libDonation
     *
     * @param string $libDonation
     *
     * @return donation
     */
    public function setLibDonation($libDonation)
    {
        $this->libDonation = $libDonation;

        return $this;
    }

    /**
     * Get libDonation
     *
     * @return string
     */
    public function getLibDonation()
    {
        return $this->libDonation;
    }

    /**
     * Set dateCr
     *
     * @param \DateTime $dateCr
     *
     * @return donation
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

    /**
     * Set valeurD
     *
     * @param integer $valeurD
     *
     * @return donation
     */
    public function setValeurD($valeurD)
    {
        $this->valeurD = $valeurD;

        return $this;
    }

    /**
     * Get valeurD
     *
     * @return int
     */
    public function getValeurD()
    {
        return $this->valeurD;
    }

    /**
     * Set photo
     *
     * @param string $photo
     *
     * @return donation
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * Get photo
     *
     * @return string
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return donation
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
     * Set categorie
     *
     * @param string $categorie
     *
     * @return donation
     */
    public function setCategorie($categorie)
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * Get categorie
     *
     * @return string
     */
    public function getCategorie()
    {
        return $this->categorie;
    }
    public function getWebPath()
    {
        return null===$this->photo ? null : $this->getUploadDir().'/'.$this->photo;
    }
    protected function getUploadRootDir()
    {
        return __DIR__.'/../../../web/'.$this->getUploadDir();
    }
    protected function getUploadDir()
    {
        return 'images';
    }
    public function UploadProfilePicture()
    {
        $this->file->move($this->getUploadRootDir(),$this->file->getClientOriginalName());
        $this->photo=$this->file->getClientOriginalName();
        $this->file=null;
    }
}

