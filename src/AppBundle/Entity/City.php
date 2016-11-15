<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * City
 *
 * @ORM\Table(name="city")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CityRepository")
 */
class City
{
	const ACTUAL_COMMUNE_ACTUELLE = 1;
	const ACTUAL_COMMUNE_ASSOCIEE = 2;
	const ACTUAL_COMMUNE_PERIMEE = 3;
	const ACTUAL_ANCIEN_CODE_CHGT_DEP = 4;
	const ACTUAL_ARRONDISSEMENT_MUNICIPAL = 5;
	const ACTUAL_COMMUNE_DELEGUEE = 6;
	const ACTUAL_FRACTION_CANTONALE = 9;
	
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="actual", type="integer")
     */
    private $actual;

    /**
     * @var int
     *
     * @ORM\Column(name="cheflieu", type="integer", nullable=true)
     */
    private $cheflieu;

    /**
     * @var int
     *
     * @ORM\Column(name="cdc", type="integer", nullable=true)
     */
    private $cdc;

    /**
     * @var int
     *
     * @ORM\Column(name="rang", type="integer", nullable=true)
     */
    private $rang;

    /**
     * @var int
     *
     * @ORM\Column(name="reg", type="integer", nullable=true)
     */
    private $reg;

    /**
     * @var string
     *
     * @ORM\Column(name="dep", type="string", length=255)
     */
    private $dep;

    /**
     * @var int
     *
     * @ORM\Column(name="com", type="integer")
     */
    private $com;

    /**
     * @var int
     *
     * @ORM\Column(name="ar", type="integer", nullable=true)
     */
    private $ar;

    /**
     * @var int
     *
     * @ORM\Column(name="ct", type="integer", nullable=true)
     */
    private $ct;

    /**
     * @var int
     *
     * @ORM\Column(name="modif", type="integer")
     */
    private $modif;

    /**
     * @var string
     *
     * @ORM\Column(name="pole", type="string", length=255, nullable=true)
     */
    private $pole;

    /**
     * @var int
     *
     * @ORM\Column(name="tncc", type="integer")
     */
    private $tncc;

    /**
     * @var string
     *
     * @ORM\Column(name="artmaj", type="string", length=255, nullable=true)
     */
    private $artmaj;

    /**
     * @var string
     *
     * @ORM\Column(name="ncc", type="string", length=255)
     */
    private $ncc;

    /**
     * @var string
     *
     * @ORM\Column(name="artmin", type="string", length=255, nullable=true)
     */
    private $artmin;

    /**
     * @var string
     *
     * @ORM\Column(name="nccenr", type="string", length=255)
     */
    private $nccenr;

    /**
     * @var string
     *
     * @ORM\Column(name="articlct", type="string", length=255, nullable=true)
     */
    private $articlct;

    /**
     * @var string
     *
     * @ORM\Column(name="nccct", type="string", length=255, nullable=true)
     */
    private $nccct;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\ResultCity",mappedBy="city")
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

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->getNccenr();
    }

    /**
     * Get full name
     *
     * @return string
     */
    public function getFullName()
    {
    	if(empty($this->getArtmin()))
        	return $this->getNccenr();
    	
		$artmin = $this->getArtmin();
		$artmin = str_replace("(", "", $artmin);
		$artmin = str_replace(")", "", $artmin);
		if(!strpos($artmin, "'") !== FALSE)// If contains "'"
			$artmin .= " ";
		
		return $artmin.$this->getName();
    }

    /**
     * Set actual
     *
     * @param integer $actual
     *
     * @return City
     */
    public function setActual($actual)
    {
        $this->actual = $actual;

        return $this;
    }

    /**
     * Get actual
     *
     * @return int
     */
    public function getActual()
    {
        return $this->actual;
    }

    /**
     * Set cheflieu
     *
     * @param integer $cheflieu
     *
     * @return City
     */
    public function setCheflieu($cheflieu)
    {
        $this->cheflieu = $cheflieu;

        return $this;
    }

    /**
     * Get cheflieu
     *
     * @return int
     */
    public function getCheflieu()
    {
        return $this->cheflieu;
    }

    /**
     * Set cdc
     *
     * @param integer $cdc
     *
     * @return City
     */
    public function setCdc($cdc)
    {
        $this->cdc = $cdc;

        return $this;
    }

    /**
     * Get cdc
     *
     * @return int
     */
    public function getCdc()
    {
        return $this->cdc;
    }

    /**
     * Set rang
     *
     * @param integer $rang
     *
     * @return City
     */
    public function setRang($rang)
    {
        $this->rang = $rang;

        return $this;
    }

    /**
     * Get rang
     *
     * @return int
     */
    public function getRang()
    {
        return $this->rang;
    }

    /**
     * Set reg
     *
     * @param integer $reg
     *
     * @return City
     */
    public function setReg($reg)
    {
        $this->reg = $reg;

        return $this;
    }

    /**
     * Get reg
     *
     * @return int
     */
    public function getReg()
    {
        return $this->reg;
    }

    /**
     * Set dep
     *
     * @param string $dep
     *
     * @return City
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
     * Set com
     *
     * @param integer $com
     *
     * @return City
     */
    public function setCom($com)
    {
        $this->com = $com;

        return $this;
    }

    /**
     * Get com
     *
     * @return int
     */
    public function getCom()
    {
        return $this->com;
    }

    /**
     * Set ar
     *
     * @param integer $ar
     *
     * @return City
     */
    public function setAr($ar)
    {
        $this->ar = $ar;

        return $this;
    }

    /**
     * Get ar
     *
     * @return int
     */
    public function getAr()
    {
        return $this->ar;
    }

    /**
     * Set ct
     *
     * @param integer $ct
     *
     * @return City
     */
    public function setCt($ct)
    {
        $this->ct = $ct;

        return $this;
    }

    /**
     * Get ct
     *
     * @return int
     */
    public function getCt()
    {
        return $this->ct;
    }

    /**
     * Set modif
     *
     * @param integer $modif
     *
     * @return City
     */
    public function setModif($modif)
    {
        $this->modif = $modif;

        return $this;
    }

    /**
     * Get modif
     *
     * @return int
     */
    public function getModif()
    {
        return $this->modif;
    }

    /**
     * Set pole
     *
     * @param string $pole
     *
     * @return City
     */
    public function setPole($pole)
    {
        $this->pole = $pole;

        return $this;
    }

    /**
     * Get pole
     *
     * @return string
     */
    public function getPole()
    {
        return $this->pole;
    }

    /**
     * Set tncc
     *
     * @param integer $tncc
     *
     * @return City
     */
    public function setTncc($tncc)
    {
        $this->tncc = $tncc;

        return $this;
    }

    /**
     * Get tncc
     *
     * @return int
     */
    public function getTncc()
    {
        return $this->tncc;
    }

    /**
     * Set artmaj
     *
     * @param string $artmaj
     *
     * @return City
     */
    public function setArtmaj($artmaj)
    {
        $this->artmaj = $artmaj;

        return $this;
    }

    /**
     * Get artmaj
     *
     * @return string
     */
    public function getArtmaj()
    {
        return $this->artmaj;
    }

    /**
     * Set ncc
     *
     * @param string $ncc
     *
     * @return City
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
     * Set artmin
     *
     * @param string $artmin
     *
     * @return City
     */
    public function setArtmin($artmin)
    {
        $this->artmin = $artmin;

        return $this;
    }

    /**
     * Get artmin
     *
     * @return string
     */
    public function getArtmin()
    {
        return $this->artmin;
    }

    /**
     * Set nccenr
     *
     * @param string $nccenr
     *
     * @return City
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

    /**
     * Set articlct
     *
     * @param string $articlct
     *
     * @return City
     */
    public function setArticlct($articlct)
    {
        $this->articlct = $articlct;

        return $this;
    }

    /**
     * Get articlct
     *
     * @return string
     */
    public function getArticlct()
    {
        return $this->articlct;
    }

    /**
     * Set nccct
     *
     * @param string $nccct
     *
     * @return City
     */
    public function setNccct($nccct)
    {
        $this->nccct = $nccct;

        return $this;
    }

    /**
     * Get nccct
     *
     * @return string
     */
    public function getNccct()
    {
        return $this->nccct;
    }

    public function getResults()
    {
    	return $this->results;
    }
    
    public function getElections()
    {
    	$elections = array();
    	$electionsIds = array();
    	
    	foreach($this->getResults() as $result) {
    		
    		$election = $result->getRound()->getElection();
    		
    		if(!in_array($election->getId(), $electionsIds)) {
    			$elections[] = $election;
    			$electionsIds[] = $election->getId();
    		}
    	}
    	
    	return $elections;
    }
}

