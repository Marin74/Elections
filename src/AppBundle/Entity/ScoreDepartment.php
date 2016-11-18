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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\ResultDepartment",inversedBy="scores")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $result;
    
    
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

