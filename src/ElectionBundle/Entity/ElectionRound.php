<?php

namespace ElectionBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\Date;

/**
 * ElectionRound
 *
 * @ORM\Table(name="election_round")
 * @ORM\Entity(repositoryClass="ElectionBundle\Repository\ElectionRoundRepository")
 */
class ElectionRound
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
     * @var int
     *
     * @ORM\Column(name="number", type="integer")
     */
    private $number;

    /**
     * @var int
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="ElectionBundle\Entity\Election",inversedBy="rounds")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $election;

    /**
     * @ORM\OneToMany(targetEntity="ElectionBundle\Entity\Candidacy",mappedBy="electionRound")
     */
    private $candidacies;

    /**
     * @ORM\OneToMany(targetEntity="ElectionBundle\Entity\Result",mappedBy="electionRound")
     */
    private $results;

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
     * @ORM\OneToMany(targetEntity="ElectionBundle\Entity\Score",mappedBy="electionRound")
     * @ORM\OrderBy({"voices" = "desc"})
     */
    private $scores;


    public function __construct() {
        $this->candidacies = new ArrayCollection();
        $this->results = new ArrayCollection();
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
     * Set number
     *
     * @param integer $number
     *
     * @return ElectionRound
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return int
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set date
     *
     * @param Date $date
     *
     * @return ElectionRound
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return Date
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set election
     *
     * @param Election $election
     *
     * @return ElectionRound
     */
    public function setElection(Election $election)
    {
        $this->election = $election;

        return $this;
    }

    /**
     * Get election
     *
     * @return Election
     */
    public function getElection()
    {
        return $this->election;
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

    /**
     * Get results
     *
     * @return ArrayCollection
     */
    public function getResults()
    {
        return $this->results;
    }

    /**
     * Set registered
     *
     * @param integer $registered
     *
     * @return ElectionRound
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
     * @return ElectionRound
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
     * @return ElectionRound
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
     * @return ElectionRound
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
     * @return ElectionRound
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

