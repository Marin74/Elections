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
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\ScoreCountry",mappedBy="nuance")
     */
    private $scoresCountry;
    
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\ScoreDepartment",mappedBy="nuance")
     */
    private $scoresDepartment;


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
    
    public function getScoresCountry()
    {
        return $this->scoresCountry;
    }
    
    public function getScoresDepartment()
    {
        return $this->scoresDepartment;
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

