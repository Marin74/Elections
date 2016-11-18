<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ResultCity
 *
 * @ORM\Table(name="result_department")
 * @ORM\Entity()
 */
class ResultDepartment extends Result
{

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\ElectionRound",inversedBy="resultsCity")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $round;
    
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Department",inversedBy="results")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $department;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\ScoreDepartment",mappedBy="result")
     * @ORM\OrderBy({"voices" = "desc"})
     */
    private $scores;
    

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

    public function getRound()
    {
    	return $this->round;
    }

    public function getDepartment()
    {
    	return $this->department;
    }

    public function getScores()
    {
    	return $this->scores;
    }
}

