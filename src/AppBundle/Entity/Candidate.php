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
    	return $this->lastname." ".$this->firstname;
    }
    
    public function setGender($gender) {
    	$this->gender = $gender;
    	
    	return $this;
    }
    
    public function getGender() {
    	return $this->gender;
    }
    
    public function getCandidacies()
    {
    	return $this->candidacies;
    }
}

