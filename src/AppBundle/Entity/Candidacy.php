<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Candidacy
 *
 * @ORM\Table(name="candidacy")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CandidacyRepository")
 */
class Candidacy
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Candidate",inversedBy="candidacies")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $candidate;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Nuance",inversedBy="candidacies")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $nuance;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\ElectionRound",inversedBy="candidacies")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $round;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\ScoreCountry",mappedBy="candidacy")
     */
    private $scores;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    
    public function setCandidate(Candidate $candidate)
    {
    	$this->candidate = $candidate;
    
    	return $this;
    }
    
    public function getCandidate()
    {
    	return $this->candidate;
    }
    
    public function setNuance(Nuance $nuance)
    {
    	$this->nuance = $nuance;
    
    	return $this;
    }
    
    public function getNuance()
    {
    	return $this->nuance;
    }
    
    public function setRound(ElectionRound $round)
    {
    	$this->round = $round;
    
    	return $this;
    }
    
    public function getRound()
    {
    	return $this->round;
    }
    
    public function getScores()
    {
    	return $this->scores;
    }
    
    public function getName() {
    	return $this->getCandidate()->getLastname()." ".$this->getCandidate()->getFirstname()." (".$this->getRound()->getRoundNumber().")";
    }
}

