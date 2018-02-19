<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DistrictCity
 *
 * @ORM\Table(name="district_city")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DistrictCityRepository")
 */
class DistrictCity
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\City",inversedBy="districtsCities")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $city;
    
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\District",inversedBy="districtsCities")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $district;
    
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\ResultDistrictCity",mappedBy="districtCity")
     */
    private $results;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    
    public function getCity()
    {
        return $this->city;
    }
    
    public function getDistrict()
    {
        return $this->district;
    }
    
    public function getResults()
    {
        return $this->results;
    }
}

