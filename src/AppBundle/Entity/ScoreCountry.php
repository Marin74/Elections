<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Score
 *
 * @ORM\Table(name="score_country")
 * @ORM\Entity()
 */
class ScoreCountry extends Score
{
    
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Nuance",inversedBy="scoresCountry")
     * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
     */
    private $nuance;
    
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\ResultCountry",inversedBy="scores")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $result;
    
    
    /**
     * Set nuance
     *
     * @param integer $nuance
     *
     * @return ScoreCity
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
    
    public function setResult(ResultCountry $result)
    {
    	$this->result = $result;
    
    	return $this;
    }
    
    public function getResult()
    {
    	return $this->result;
    }
}

