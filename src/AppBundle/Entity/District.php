<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * District
 *
 * @ORM\Table(name="district")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DistrictRepository")
 */
class District
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Department",inversedBy="districts")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $department;

    /**
     * @var int
     *
     * @ORM\Column(name="code", type="integer")
     */
    private $code;
    
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Candidacy",mappedBy="district")
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
    
    public function getDepartment()
    {
        return $this->department;
    }

    /**
     * Set code
     *
     * @param integer $code
     *
     * @return District
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return int
     */
    public function getCode()
    {
        return $this->code;
    }
    
    public function getCandidacies()
    {
        return $this->candidacies;
    }
}

