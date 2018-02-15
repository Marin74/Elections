<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Candidate
 *
 * @ORM\Table(name="candidate")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CandidateRepository")
 */
class Candidate
{
	const GENDER_MALE = "M";
	const GENDER_FEMALE = "F";
	
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
     * @ORM\Column(name="firstname", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $lastname;

    /**
     * @var string
     *
     * @ORM\Column(name="gender", type="string", length=1)
     * @Assert\NotBlank()
     */
    private $gender;

    /**
     * @var string
     *
     * @ORM\Column(name="dateOfBirth", type="date", nullable=true)
     */
    private $dateOfBirth;

    /**
     * @var string
     *
     * @ORM\Column(name="dateOfDeath", type="date", nullable=true)
     */
    private $dateOfDeath;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Candidacy",mappedBy="candidate")
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
     * Set firstname
     *
     * @param string $firstname
     *
     * @return Candidate
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     *
     * @return Candidate
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }
    
    public function getReverseName() {
    	return $this->getLastname()." ".$this->getFirstname();
    }
    
    public function getName() {
    	return $this->getFirstname()." ".$this->getLastname();
    }
    
    public function setGender($gender) {
    	$this->gender = $gender;
    	
    	return $this;
    }
    
    public function getGender() {
    	return $this->gender;
    }
    
    public function setDateOfBirth($dateOfBirth) {
    	$this->dateOfBirth = $dateOfBirth;
    	
    	return $this;
    }
    
    public function getDateOfBirth() {
    	return $this->dateOfBirth;
    }
    
    public function setDateOfDeath($dateOfDeath) {
    	$this->dateOfDeath = $dateOfDeath;
    	
    	return $this;
    }
    
    public function getDateOfDeath() {
    	return $this->dateOfDeath;
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

