<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Score
 *
 */
abstract class Score
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
     * @ORM\Column(name="voices", type="integer")
     */
    protected $voices;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Candidacy",inversedBy="scores")
     * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
     */
    protected $candidacy;
    
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Nuance",inversedBy="scores")
     * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
     */
    protected $nuance;// TODO Virer la nuance dans ScoreDistrict et ScoreDistrictCity


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
    
    public function setCandidacy(Candidacy $candidacy)
    {
        $this->candidacy = $candidacy;

        return $this;
    }
    
    public function getCandidacy()
    {
        return $this->candidacy;
    }
    
    /**
     * Set nuance
     *
     * @param integer $nuance
     *
     * @return Score
     */
    public function setNuance($nuance)
    {
        $this->nuance = $nuance;
        
        return $this;
    }
    
    /**
     * Get nuance
     *
     * @return Nuance
     */
    public function getNuance()
    {
        return $this->nuance;
    }
}

