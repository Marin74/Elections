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
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

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
    
    public function setDescription($description)
    {
    	$this->description = $description;
    	
    	return $this;
    }
    
    public function getDescription()
    {
    	return $this->description;
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
    
    public function getURLName()
    {
    	$name = "-";
    	
    	if(!empty($name)) {
    		$name = strtolower($this->getName());
    		
    		$name = str_replace("'", "", $name);
    		$name = str_replace('"', "", $name);
    		$name = str_replace("/", "", $name);
    		$name = str_replace("|", "", $name);
    		$name = str_replace('\\', "", $name);
    		$name = str_replace('?', "", $name);
    		$name = str_replace('!', "", $name);
    		$name = str_replace('(', "", $name);
    		$name = str_replace(')', "", $name);
    		$name = str_replace('°', "", $name);
    		$name = str_replace('&', "", $name);
    		$name = str_replace('§', "", $name);
    		$name = str_replace('*', "", $name);
    		$name = str_replace('%', "", $name);
    		$name = str_replace(':', "", $name);
    		$name = str_replace(',', "", $name);
    		$name = str_replace('=', "", $name);
    		$name = str_replace('+', "", $name);
    		$name = str_replace('%', "", $name);
    		$name = str_replace('.', "", $name);
    		$name = str_replace('<', "", $name);
    		$name = str_replace('>', "", $name);
    		$name = str_replace('@', "", $name);
    		$name = str_replace('#', "", $name);
    		
    		// Lowercase
    		$name = str_replace("é", "e", $name);
    		$name = str_replace("è", "e", $name);
    		$name = str_replace("ê", "e", $name);
    		$name = str_replace("ë", "e", $name);
    		$name = str_replace("â", "a", $name);
    		$name = str_replace("à", "a", $name);
    		$name = str_replace("ä", "a", $name);
    		$name = str_replace("ô", "o", $name);
    		$name = str_replace("ö", "o", $name);
    		$name = str_replace("ù", "u", $name);
    		$name = str_replace("ü", "u", $name);
    		$name = str_replace("î", "i", $name);
    		$name = str_replace("ï", "i", $name);
    		$name = str_replace("ç", "c", $name);
    		$name = str_replace("æ", "ae", $name);
    		$name = str_replace("œ", "oe", $name);

            // Uppercase
            $name = str_replace("É", "e", $name);
            $name = str_replace("È", "e", $name);
            $name = str_replace("Ê", "e", $name);
            $name = str_replace("Ë", "e", $name);
            $name = str_replace("Â", "a", $name);
            $name = str_replace("À", "a", $name);
            $name = str_replace("Ä", "a", $name);
            $name = str_replace("Ô", "o", $name);
            $name = str_replace("Ö", "o", $name);
            $name = str_replace("Ù", "u", $name);
            $name = str_replace("Ü", "u", $name);
            $name = str_replace("Î", "i", $name);
            $name = str_replace("Ï", "i", $name);
            $name = str_replace("Ç", "c", $name);
            $name = str_replace("Æ", "ae", $name);
            $name = str_replace("Œ", "oe", $name);
            
            $name = trim($name);
            
            $name = str_replace(" ", "-", $name);
    		
    		while(strpos($name, "--") !== false) {
    			 
    			$name = str_replace("--", "-", $name);
    		}
    	}
    	
    	return $name;
    }
}

