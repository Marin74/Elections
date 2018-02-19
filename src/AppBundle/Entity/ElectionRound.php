<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ElectionRound
 *
 * @ORM\Table(name="election_round")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ElectionRoundRepository")
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
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     * @Assert\NotBlank()
     */
    private $date;

    /**
     * @var int
     *
     * @ORM\Column(name="roundNumber", type="integer")
     * @Assert\NotBlank()
     */
    private $roundNumber;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Election",inversedBy="rounds")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $election;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Candidacy",mappedBy="round")
     */
    private $candidacies;

    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\ResultCountry", inversedBy="round", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
     */
    private $resultCountry;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\ResultCity",mappedBy="round")
     */
    private $resultsCity;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\ResultDepartment",mappedBy="round")
     */
    private $resultsDepartment;
    
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\ResultDistrict",mappedBy="round")
     */
    private $resultsDistrict;
    
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\ResultDistrictCity",mappedBy="round")
     */
    private $resultsDistrictCity;


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
     * Set date
     *
     * @param \DateTime $date
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
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set roundNumber
     *
     * @param integer $roundNumber
     *
     * @return ElectionRound
     */
    public function setRoundNumber($roundNumber)
    {
        $this->roundNumber = $roundNumber;

        return $this;
    }

    /**
     * Get roundNumber
     *
     * @return int
     */
    public function getRoundNumber()
    {
        return $this->roundNumber;
    }
    
    public function setElection(Election $election)
    {
    	$this->election = $election;
    
    	return $this;
    }
    
    public function getElection()
    {
    	return $this->election;
    }
    
    public function getCandidacies()
    {
    	return $this->candidacies;
    }
    
    public function setResultCountry(ResultCountry $resultCountry)
    {
    	$this->resultCountry = $resultCountry;
    	
    	return $this;
    }
    
    public function getResultCountry()
    {
    	return $this->resultCountry;
    }
    
    public function getResultsCity()
    {
    	return $this->resultsCity;
    }
    
    public function getResultsDepartment()
    {
    	return $this->resultsDepartment;
    }
    
    public function getResultsDistrict()
    {
        return $this->resultsDistrict;
    }
    
    public function getResultsDistrictCity()
    {
        return $this->resultsDistrictCity;
    }
}

