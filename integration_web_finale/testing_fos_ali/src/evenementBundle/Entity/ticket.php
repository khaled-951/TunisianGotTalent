<?php

namespace evenementBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ticket
 *
 * @ORM\Table(name="ticket")
 * @ORM\Entity(repositoryClass="evenementBundle\Repository\ticketRepository")
 */
class ticket
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_ticket", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    public $id_ticket;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateemission", type="date")
     */
    private $dateemission;

    /**
     * @return int
     */
    public function getIdTicket()
    {
        return $this->id_ticket;
    }

    /**
     * @param int $id_ticket
     */
    public function setIdTicket($id_ticket)
    {
        $this->id_ticket = $id_ticket;
    }


    /**
     * @ORM\ManyToOne(targetEntity="evenement")
     * @ORM\JoinColumn(name="evenement_id",referencedColumnName="id_evenement")
     */
    public $evenement;

    /**
     * @return mixed
     */
    public function getEvenement()
    {
        return $this->evenement;
    }

    /**
     * @param mixed $evenement
     */
    public function setEvenement($evenement)
    {
        $this->evenement = $evenement;
    }



    /**
     * Set dateemission
     *
     * @param \DateTime $dateemission
     *
     * @return ticket
     */
    public function setDateemission($dateemission)
    {
        $this->dateemission = $dateemission;

        return $this;
    }

    /**
     * Get dateemission
     *
     * @return \DateTime
     */
    public function getDateemission()
    {
        return $this->dateemission;
    }
}

