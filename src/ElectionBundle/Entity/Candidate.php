<?php

namespace ElectionBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Candidate
 *
 * @ORM\Table(name="candidate")
 * @ORM\Entity(repositoryClass="ElectionBundle\Repository\CandidateRepository")
 */
class Candidate
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
     * @ORM\Column(name="firstname", type="string", length=255)
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=255)
     */
    private $lastname;

    /**
     * @ORM\ManyToMany(targetEntity="ElectionBundle\Entity\ElectionRound",mappedBy="candidates")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $electionRounds;

    /**
     * @ORM\ManyToMany(targetEntity="ElectionBundle\Entity\Candidacy",mappedBy="candidate")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $candidacies;


    public function __construct() {
        $this->electionRounds = new ArrayCollection();
        $this->candidacies = new ArrayCollection();
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
     * Set firstname
     *
     * @param string $firstname
     *
     * @return Candidate
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     *
     * @return Candidate
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Get firstname + lastname
     *
     * @return string
     */
    public function getName()
    {
        return $this->firstname . " " . $this->lastname;
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

    /**
     * Get candidacies
     *
     * @return ArrayCollection
     */
    public function getCandidacies()
    {
        return $this->candidacies;
    }
}

