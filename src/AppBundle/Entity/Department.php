<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Department
 *
 * @ORM\Table(name="department")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DepartmentRepository")
 */
class Department
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
     * @ORM\Column(name="region", type="string", length=255)
     */
    private $region;

    /**
     * @var string
     *
     * @ORM\Column(name="dep", type="string", length=255, unique=true)
     */
    private $dep;

    /**
     * @var string
     *
     * @ORM\Column(name="cheflieu", type="string", length=255)
     */
    private $cheflieu;

    /**
     * @var string
     *
     * @ORM\Column(name="tncc", type="string", length=255)
     */
    private $tncc;

    /**
     * @var string
     *
     * @ORM\Column(name="ncc", type="string", length=255)
     */
    private $ncc;

    /**
     * @var string
     *
     * @ORM\Column(name="nccenr", type="string", length=255)
     */
    private $nccenr;


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
     * Set region
     *
     * @param string $region
     *
     * @return Department
     */
    public function setRegion($region)
    {
        $this->region = $region;

        return $this;
    }

    /**
     * Get region
     *
     * @return string
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Set dep
     *
     * @param string $dep
     *
     * @return Department
     */
    public function setDep($dep)
    {
        $this->dep = $dep;

        return $this;
    }

    /**
     * Get dep
     *
     * @return string
     */
    public function getDep()
    {
        return $this->dep;
    }

    /**
     * Set cheflieu
     *
     * @param string $cheflieu
     *
     * @return Department
     */
    public function setCheflieu($cheflieu)
    {
        $this->cheflieu = $cheflieu;

        return $this;
    }

    /**
     * Get cheflieu
     *
     * @return string
     */
    public function getCheflieu()
    {
        return $this->cheflieu;
    }

    /**
     * Set tncc
     *
     * @param string $tncc
     *
     * @return Department
     */
    public function setTncc($tncc)
    {
        $this->tncc = $tncc;

        return $this;
    }

    /**
     * Get tncc
     *
     * @return string
     */
    public function getTncc()
    {
        return $this->tncc;
    }

    /**
     * Set ncc
     *
     * @param string $ncc
     *
     * @return Department
     */
    public function setNcc($ncc)
    {
        $this->ncc = $ncc;

        return $this;
    }

    /**
     * Get ncc
     *
     * @return string
     */
    public function getNcc()
    {
        return $this->ncc;
    }

    /**
     * Set nccenr
     *
     * @param string $nccenr
     *
     * @return Department
     */
    public function setNccenr($nccenr)
    {
        $this->nccenr = $nccenr;

        return $this;
    }

    /**
     * Get nccenr
     *
     * @return string
     */
    public function getNccenr()
    {
        return $this->nccenr;
    }
}

