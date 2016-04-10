<?php

namespace ElectionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Candidacy
 *
 * @ORM\Table(name="candidacy")
 * @ORM\Entity(repositoryClass="ElectionBundle\Repository\CandidacyRepository")
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
     * @ORM\ManyToOne(targetEntity="ElectionBundle\Entity\ElectionRound",inversedBy="candidacies")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $electionRound;

    /**
     * @ORM\ManyToOne(targetEntity="ElectionBundle\Entity\Candidate",inversedBy="candidacies")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $candidate;

    /**
     * @ORM\ManyToOne(targetEntity="ElectionBundle\Entity\PoliticalNuance")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $politicalNuance;


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
     * @return Candidacy
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
    public function getelectionRound()
    {
        return $this->electionRound;
    }

    /**
     * Set candidate
     *
     * @param Candidate $candidate
     *
     * @return Candidacy
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
     * Set politicalNuance
     *
     * @param PoliticalNuance $politicalNuance
     *
     * @return Candidacy
     */
    public function setPoliticalNuance(PoliticalNuance $politicalNuance)
    {
        $this->politicalNuance = $politicalNuance;

        return $this;
    }

    /**
     * Get politicalNuance
     *
     * @return PoliticalNuance
     */
    public function getPoliticalNuance()
    {
        return $this->politicalNuance;
    }
}

