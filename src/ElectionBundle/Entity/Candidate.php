<?php

namespace ElectionBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Candidate
 *
 * @ORM\Table(name="candidate")
 * @ORM\Entity(repositoryClass="ElectionBundle\Repository\CandidateRepository")
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
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=255)
     */
    private $lastname;

    /**
     * @var string
     *
     * @ORM\Column(name="gender", type="string", length=1)
     */
    private $gender;

    /**
     * @ORM\ManyToMany(targetEntity="ElectionBundle\Entity\Candidacy",mappedBy="candidate")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $candidacies;


    public function __construct() {
        $this->candidacies = new ArrayCollection();
    }


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

    /**
     * Get firstname + lastname
     *
     * @return string
     */
    public function getName()
    {
        return $this->firstname . " " . $this->lastname;
    }

    /**
     * Set gender
     *
     * @return Candidate
     */
    public function setMale()
    {
        $this->gender = Candidate::GENDER_MALE;

        return $this;
    }

    /**
     * Set gender
     *
     * @return Candidate
     */
    public function setFemale()
    {
        $this->gender = Candidate::GENDER_FEMALE;

        return $this;
    }

    /**
     * Get isMale
     *
     * @return boolean
     */
    public function isMale()
    {
        return $this->gender == Candidate::GENDER_MALE;
    }

    /**
     * Get isFemale
     *
     * @return boolean
     */
    public function isFemale()
    {
        return $this->gender == Candidate::GENDER_FEMALE;
    }

    /**
     * Get candidacies
     *
     * @return ArrayCollection
     */
    public function getCandidacies()
    {
        return $this->candidacies;
    }
}

