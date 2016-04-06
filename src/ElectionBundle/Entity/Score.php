<?php

namespace ElectionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Score
 *
 * @ORM\Table(name="score")
 * @ORM\Entity(repositoryClass="ElectionBundle\Repository\ScoreRepository")
 */
class Score
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
     * @ORM\ManyToOne(targetEntity="ElectionBundle\Entity\Result",inversedBy="scores")
     * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
     */
    private $result;

    /**
     * @ORM\ManyToOne(targetEntity="ElectionBundle\Entity\ElectionRound",inversedBy="scores")
     * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
     */
    private $electionRound;

    /**
     * @ORM\ManyToOne(targetEntity="ElectionBundle\Entity\Candidate",inversedBy="scores")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $candidate;

    /**
     * @var int
     *
     * @ORM\Column(name="voices", type="integer")
     */
    private $voices;


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
     * Set result
     *
     * @param Result $result
     *
     * @return Score
     */
    public function setResult(Result $result)
    {
        $this->result = $result;

        return $this;
    }

    /**
     * Get result
     *
     * @return Result
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * Set electionRound
     *
     * @param ElectionRound $electionRound
     *
     * @return Score
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
     * Set candidate
     *
     * @param Candidate $candidate
     *
     * @return Score
     */
    public function setCandidate(Candidate $candidate)
    {
        $this->candidate = $candidate;

        return $this;
    }

    /**
     * Get candidate
     *
     * @return Candidate
     */
    public function getCandidate()
    {
        return $this->candidate;
    }

    /**
     * Set voices
     *
     * @param integer $voices
     *
     * @return Score
     */
    public function setVoices($voices)
    {
        $this->voices = $voices;

        return $this;
    }

    /**
     * Get voices
     *
     * @return int
     */
    public function getVoices()
    {
        return $this->voices;
    }
}

