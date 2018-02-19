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
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\City",mappedBy="department")
     * @ORM\OrderBy({"nccenr" = "asc"})
     */
    private $cities;
    
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\District",mappedBy="department")
     * @ORM\OrderBy({"code" = "asc"})
     */
    private $districts;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\ResultDepartment",mappedBy="department")
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

    public function getName()
    {
    	return $this->getNccenr();
    }

    public function getResults()
    {
    	return $this->results;
    }
    
    public function getDistricts()
    {
        return $this->districts;
    }
    
    public function getElections()
    {
    	$electionsIds = array();
    	$unsortedElections = array();
    	
    	foreach($this->getResults() as $result) {
    		
    		$election = $result->getRound()->getElection();
    		
    		if(!in_array($election->getId(), $electionsIds)) {
    		    
    			$electionsIds[] = $election->getId();
    			
    			$unsortedElections[$election->getId().$election->getName()] = $election;
    		}
    	}
    	
    	// Sort
    	arsort($unsortedElections);
    	
    	$elections = array();
    	foreach($unsortedElections as $key => $election) {
    	    $elections[] = $election;
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

