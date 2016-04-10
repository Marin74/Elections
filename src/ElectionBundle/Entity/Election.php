<?php

namespace ElectionBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Election
 *
 * @ORM\Table(name="election")
 * @ORM\Entity(repositoryClass="ElectionBundle\Repository\ElectionRepository")
 */
class Election
{
    const TYPE_PRESIDENTIAL = 1;// Presidential election


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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var integer
     *
     * @ORM\Column(name="type", type="integer")
     */
    private $type;

    /**
     * @ORM\OneToMany(targetEntity="ElectionBundle\Entity\ElectionRound",mappedBy="election")
     */
    private $electionRounds;
    

    public function __construct() {
        $this->electionRounds = new ArrayCollection();
    }


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
     * Set name
     *
     * @param string $name
     *
     * @return Election
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set type
     *
     * @param integer $type
     *
     * @return Election
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return integer
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Get electionRounds
     *
     * @return ArrayCollection
     */
    public function getElectionRounds()
    {
        return $this->electionRounds;
    }
}

