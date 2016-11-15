<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ElectionType
 *
 * @ORM\Table(name="election_type")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ElectionTypeRepository")
 */
class ElectionType
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
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Election",mappedBy="type")
     * @ORM\OrderBy({"name" = "desc"})
     */
    private $elections;


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
     * @return ElectionType
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
    
    public function getElections()
    {
    	return $this->elections;
    }
}

