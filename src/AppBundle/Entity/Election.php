<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Election
 *
 * @ORM\Table(name="election")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ElectionRepository")
 */
class Election
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
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\ElectionType",inversedBy="elections")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     * @Assert\NotBlank()
     */
    private $type;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\ElectionRound",mappedBy="election")
     * @ORM\OrderBy({"roundNumber" = "desc"})
     */
    private $rounds;


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
     * Set name
     *
     * @param string $name
     *
     * @return Election
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
    
    public function setType(ElectionType $electionType)
    {
    	$this->type = $electionType;
    
    	return $this;
    }
    
    public function getType()
    {
    	return $this->type;
    }
    
    public function setRounds($rounds)
    {
    	$this->rounds = $rounds;
    	
    	return $this;
    }
    
    public function getRounds()
    {
    	return $this->rounds;
    }
}

