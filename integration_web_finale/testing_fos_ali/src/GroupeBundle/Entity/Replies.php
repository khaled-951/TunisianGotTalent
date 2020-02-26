<?php

namespace GroupeBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Replies
 *
 * @ORM\Table(name="replies")
 * @ORM\Entity(repositoryClass="GroupeBundle\Repository\RepliesRepository")
 */
class Replies
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
     * @Assert\Length(min="20", minMessage="this description is too short")
     * @ORM\Column(name="contenu", type="string", length=1000)
     */
    private $contenu;

    /**
     * @var string
     *
     * @ORM\Column(name="date", type="string", length=255)
     */
    private $date;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="date_replay", type="datetime")
     */
    private $dateReplay;

    /**
     * @var string
     *
     * @ORM\Column(name="relayBy", type="string", length=255)
     */
    private $relayBy;

    /**
     * @return mixed
     */
    public function getTopic()
    {
        return $this->topic;
    }

    /**
     * @param mixed $topic
     */
    public function setTopic($topic)
    {
        $this->topic = $topic;
    }
    /**
     * @ORM\ManyToOne(targetEntity="Topics")
     * @ORM\JoinColumn(name="topic_id",referencedColumnName="id")
     */
    private $topic;

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
     * Set contenu
     *
     * @param string $contenu
     *
     * @return Replies
     */
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;

        return $this;
    }

    /**
     * Get contenu
     *
     * @return string
     */
    public function getContenu()
    {
        return $this->contenu;
    }

    /**
     * Set date
     *
     * @param string $date
     *
     * @return Replies
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return string
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set dateReplay
     *
     * @param DateTime $dateReplay
     *
     * @return Replies
     */
    public function setDateReplay($dateReplay)
    {
        $this->dateReplay = $dateReplay;

        return $this;
    }

    /**
     * Get dateReplay
     *
     *
     * @return DateTime
     */
    public function getDateReplay()
    {
        return $this->dateReplay;
    }

    /**
     * Set relayBy
     *
     * @param string $relayBy
     *
     * @return Replies
     */
    public function setRelayBy($relayBy)
    {
        $this->relayBy = $relayBy;

        return $this;
    }

    /**
     * Get relayBy
     *
     * @return string
     */
    public function getRelayBy()
    {
        return $this->relayBy;
    }
}

