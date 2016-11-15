<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Result
 *
 */
abstract class Result
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var int
     *
     * @ORM\Column(name="registered", type="integer", nullable=true)
     */
    protected $registered;

    /**
     * @var int
     *
     * @ORM\Column(name="abstention", type="integer", nullable=true)
     */
    protected $abstention;

    /**
     * @var int
     *
     * @ORM\Column(name="voters", type="integer", nullable=true)
     */
    protected $voters;

    /**
     * @var int
     *
     * @ORM\Column(name="blankAndInvalidVotes", type="integer", nullable=true)
     */
    protected $blankAndInvalidVotes;

    /**
     * @var int
     *
     * @ORM\Column(name="votesCast", type="integer", nullable=true)
     */
    protected $votesCast;


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
}

