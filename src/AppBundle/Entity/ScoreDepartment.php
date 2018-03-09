<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Score
 *
 * @ORM\Table(name="score_department")
 * @ORM\Entity()
 */
class ScoreDepartment extends Score
{
    
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Nuance",inversedBy="scoresDepartment")
     * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
     */
    private $nuance;
    
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\ResultDepartment",inversedBy="scores")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $result;
    
    
    /**
     * Set nuance
     *
     * @param integer $nuance
     *
     * @return ScoreDepartment
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
    
    public function setResult(ResultCity $result)
    {
    	$this->result = $result;
    
    	return $this;
    }
    
    public function getResult()
    {
    	return $this->result;
    }
}

