<?php

namespace ElectionBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Result
 *
 * @ORM\Table(name="result")
 * @ORM\Entity(repositoryClass="ElectionBundle\Repository\ResultRepository")
 */
class Result
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
     * @ORM\ManyToOne(targetEntity="ElectionBundle\Entity\ElectionRound",inversedBy="results")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $electionRound;

    /**
     * @ORM\ManyToOne(targetEntity="ElectionBundle\Entity\Town",inversedBy="results")
     * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
     */
    private $town;

    /**
     * @ORM\ManyToOne(targetEntity="ElectionBundle\Entity\Department",inversedBy="results")
     * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
     */
    private $department;

    /**
     * @var int
     *
     * @ORM\Column(name="registered", type="integer")
     */
    private $registered;

    /**
     * @var int
     *
     * @ORM\Column(name="abstention", type="integer")
     */
    private $abstention;

    /**
     * @var int
     *
     * @ORM\Column(name="voters", type="integer")
     */
    private $voters;

    /**
     * @var int
     *
     * @ORM\Column(name="blankAndInvalidVotes", type="integer")
     */
    private $blankAndInvalidVotes;

    /**
     * @var int
     *
     * @ORM\Column(name="votesCast", type="integer")
     */
    private $votesCast;

    /**
     * @ORM\OneToMany(targetEntity="ElectionBundle\Entity\Score",mappedBy="result")
     * @ORM\OrderBy({"voices" = "desc"})
     */
    private $scores;


    public function __construct() {
        $this->scores = new ArrayCollection();
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
     * Set electionRound
     *
     * @param ElectionRound $electionRound
     *
     * @return Result
     */
    public function setElectionRound(ElectionRound $electionRound)
    {
        $this->electionRound = $electionRound;

        return $this;
    }

    /**
     * Get electionRound
     *
     * @return ElectionRound
     */
    public function getElectionRound()
    {
        return $this->electionRound;
    }

    /**
     * Set town
     *
     * @param Town $town
     *
     * @return Result
     */
    public function setTown(Town $town)
    {
        $this->town = $town;

        return $this;
    }

    /**
     * Get town
     *
     * @return Town
     */
    public function getTown()
    {
        return $this->town;
    }

    /**
     * Set department
     *
     * @param Department $department
     *
     * @return Result
     */
    public function setDepartment(Department $department)
    {
        $this->department = $department;

        return $this;
    }

    /**
     * Get department
     *
     * @return Department
     */
    public function getDepartment()
    {
        return $this->department;
    }

    /**
     * Set registered
     *
     * @param integer $registered
     *
     * @return Result
     */
    public function setRegistered($registered)
    {
        $this->registered = $registered;

        return $this;
    }

    /**
     * Get registered
     *
     * @return int
     */
    public function getRegistered()
    {
        return $this->registered;
    }

    /**
     * Set abstention
     *
     * @param integer $abstention
     *
     * @return Result
     */
    public function setAbstention($abstention)
    {
        $this->abstention = $abstention;

        return $this;
    }

    /**
     * Get abstention
     *
     * @return int
     */
    public function getAbstention()
    {
        return $this->abstention;
    }

    /**
     * Set voters
     *
     * @param integer $voters
     *
     * @return Result
     */
    public function setVoters($voters)
    {
        $this->voters = $voters;

        return $this;
    }

    /**
     * Get voters
     *
     * @return int
     */
    public function getVoters()
    {
        return $this->voters;
    }

    /**
     * Set blankAndInvalidVotes
     *
     * @param integer $blankAndInvalidVotes
     *
     * @return Result
     */
    public function setBlankAndInvalidVotes($blankAndInvalidVotes)
    {
        $this->blankAndInvalidVotes = $blankAndInvalidVotes;

        return $this;
    }

    /**
     * Get blankAndInvalidVotes
     *
     * @return int
     */
    public function getBlankAndInvalidVotes()
    {
        return $this->blankAndInvalidVotes;
    }

    /**
     * Set votesCast
     *
     * @param integer $votesCast
     *
     * @return Result
     */
    public function setVotesCast($votesCast)
    {
        $this->votesCast = $votesCast;

        return $this;
    }

    /**
     * Get votesCast
     *
     * @return int
     */
    public function getVotesCast()
    {
        return $this->votesCast;
    }

    /**
     * Get scores
     *
     * @return ArrayCollection
     */
    public function getScores()
    {
        return $this->scores;
    }
}

