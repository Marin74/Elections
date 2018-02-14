<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Nuance
 *
 * @ORM\Table(name="nuance")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\NuanceRepository")
 */
class Nuance
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
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=255, unique=true)
     * @Assert\NotBlank()
     */
    private $code;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="color", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $color;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Candidacy",mappedBy="nuance")
     */
    private $candidacies;


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
     * Set code
     *
     * @param string $code
     *
     * @return Nuance
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Nuance
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set color
     *
     * @param string $color
     *
     * @return Nuance
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color
     *
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }
    
    public function getCandidacies()
    {
    	return $this->candidacies;
    }
    
    public function getElections()
    {
        $elections = array();
        $electionsIds = array();
        
        foreach($this->getCandidacies() as $candidacy) {
            
            $election = $candidacy->getRound()->getElection();
            
            if(!in_array($election->getId(), $electionsIds)) {
                
                $electionsIds[] = $election->getId();
                $elections[] = $election;
            }
        }
        
        return $elections;
    }
}

