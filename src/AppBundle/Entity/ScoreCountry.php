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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\ResultCountry",inversedBy="scores")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $result;
    
    
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

