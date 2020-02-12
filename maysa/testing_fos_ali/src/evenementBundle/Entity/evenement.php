<?php

namespace evenementBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert ;
use Symfony\Component\HttpFoundation\File\UploadedFile;
/**
 * evenement
 *
 * @ORM\Table(name="evenement")
 * @ORM\Entity(repositoryClass="evenementBundle\Repository\evenementRepository")
 */
class evenement
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_evenement", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    public $id_evenement;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=255)
     */
    private $titre;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datedebut", type="date")
     */
    private $datedebut;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datefin", type="date")
     */
    private $datefin;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="typedetalent", type="string", length=255)
     */
    private $typedetalent;

    /**
     * @var int
     *
     * @ORM\Column(name="cout", type="integer")
     */
    private $cout;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    private $participe ;

    private $diamond ;

    /**
     * @return mixed
     */
    public function getDiamond()
    {
        return $this->diamond;
    }

    /**
     * @param mixed $diamond
     */
    public function setDiamond($diamond)
    {
        $this->diamond = $diamond;
    }

    /**
     * @return mixed
     */
    public function getParticipe()
    {
        return $this->participe;
    }

    /**
     * @param mixed $participe
     */
    public function setParticipe($participe)
    {
        $this->participe = $participe;
    }



    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param string $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }


    /**
     * @Assert\File(maxSize="6000000")
     */
    private $file;


    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }



    public function getAbsoluteImage()
    {
        return null === $this->image
            ? null
            : $this->getUploadRootDir().'/'.$this->image;
    }

    public function getWebImage()
    {
        return null === $this->image
            ? null
            : $this->getUploadDir().'/'.$this->image;
    }

    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return 'template/images';
    }




    public function upload()
    {
        // the file property can be empty if the field is not required
        if (null === $this->getFile()) {
            return;
        }

        // use the original file name here but you should
        // sanitize it at least to avoid any security issues

        // move takes the target directory and then the
        // target filename to move to
        $this->getFile()->move(
            $this->getUploadRootDir(),
            $this->getFile()->getClientOriginalName()
        );

        // set the image property to the filename where you've saved the file
        $this->image = $this->getFile()->getClientOriginalName();

        // clean up the file property as you won't need it anymore
        $this->file = null;
    }











    /**
     * @return int
     */
    public function getIdEvenement()
    {
        return $this->id_evenement;
    }

    /**
     * @param int $id_evenement
     */
    public function setIdEvenement($id_evenement)
    {
        $this->id_evenement = $id_evenement;
    }




    /**
     * Set titre
     *
     * @param string $titre
     *
     * @return evenement
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set datedebut
     *
     * @param \DateTime $datedebut
     *
     * @return evenement
     */
    public function setDatedebut($datedebut)
    {
        $this->datedebut = $datedebut;

        return $this;
    }

    /**
     * Get datedebut
     *
     * @return \DateTime
     */
    public function getDatedebut()
    {
        return $this->datedebut;
    }

    /**
     * Set datefin
     *
     * @param \DateTime $datefin
     *
     * @return evenement
     */
    public function setDatefin($datefin)
    {
        $this->datefin = $datefin;

        return $this;
    }

    /**
     * Get datefin
     *
     * @return \DateTime
     */
    public function getDatefin()
    {
        return $this->datefin;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return evenement
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
     * Set typedetalent
     *
     * @param string $typedetalent
     *
     * @return evenement
     */
    public function setTypedetalent($typedetalent)
    {
        $this->typedetalent = $typedetalent;

        return $this;
    }

    /**
     * Get typedetalent
     *
     * @return string
     */
    public function getTypedetalent()
    {
        return $this->typedetalent;
    }

    /**
     * Set cout
     *
     * @param integer $cout
     *
     * @return evenement
     */
    public function setCout($cout)
    {
        $this->cout = $cout;

        return $this;
    }

    /**
     * Get cout
     *
     * @return int
     */
    public function getCout()
    {
        return $this->cout;
    }












}

