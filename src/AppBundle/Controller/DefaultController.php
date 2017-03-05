<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\ElectionType;
use AppBundle\Entity\City;
use AppBundle\Entity\Department;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
    	$em = $this->getDoctrine()->getManager();
    	$repoElectionRound = $em->getRepository("AppBundle:ElectionRound");
    	$round = $repoElectionRound->findOneBy(array(), array("date" => "DESC"));
    	
        return $this->render('AppBundle:Default:index.html.twig', array(
        	'round'	=> $round
        ));
    }
    
    public function electionsAction(Request $request)
    {
    	$em = $this->getDoctrine()->getManager();
    	$repoElectionType = $em->getRepository("AppBundle:ElectionType");
    	$electionTypes = $repoElectionType->findBy(array(), array("name" => "ASC"));
    	
        return $this->render('AppBundle:Default:elections.html.twig', array(
        	'electionTypes' => $electionTypes,
        ));
    }
    
    public function electionAction(Request $request)
    {
    	$em = $this->getDoctrine()->getManager();
    	$repoElection = $em->getRepository("AppBundle:Election");
    	$electionId = $request->get("id");
    	$election = null;
    	$previousElection = null;
    	$nextElection = null;
    	
    	if(!empty($electionId)) {
    		$election = $repoElection->find($electionId);
    		
    		if($election != null && count($election->getRounds()) > 0) {
    			
    			$previousElection = $repoElection->createQueryBuilder("e")
    				->join("e.rounds", "r")
	    			->select("e")
	    			->where("e.type = :type")
	    			->andWhere("r.roundNumber = 1")
	    			->andWhere("r.date < :date")
	    			->andWhere("e != :election")
	    			->setParameter("type", $election->getType())
	    			->setParameter("date", $election->getRounds()[0]->getDate())
	    			->setParameter("election", $election)
	    			->orderBy("r.date", "DESC")
	    			->setMaxResults(1)
	    			->getQuery()
	    			->getOneOrNullResult();
    			
	    		$nextElection = $repoElection->createQueryBuilder("e")
    				->join("e.rounds", "r")
	    			->select("e")
	    			->where("e.type = :type")
	    			->andWhere("r.roundNumber = 1")
	    			->andWhere("r.date > :date")
	    			->andWhere("e != :election")
	    			->setParameter("type", $election->getType())
	    			->setParameter("date", $election->getRounds()[0]->getDate())
	    			->setParameter("election", $election)
	    			->orderBy("r.date", "ASC")
	    			->setMaxResults(1)
	    			->getQuery()
	    			->getOneOrNullResult();
    		}
    	}
    	
        return $this->render('AppBundle:Default:election.html.twig', array(
        	'election'			=> $election,
        	'previousElection'	=> $previousElection,
        	'nextElection'		=> $nextElection
        ));
    }
    
    public function searchAction(Request $request)
    {
    	$em = $this->getDoctrine()->getManager();
    	$repoCity = $em->getRepository("AppBundle:City");
    	$search = trim($request->get("search"));
    	$results = array();
    	
    	if(!empty($search)) {
    		$query = $repoCity->createQueryBuilder('c');
    		$query
    		->where($query->expr()->notIn("c.actual", ":actual"))
    		->andWhere(
    			$query->expr()->orX(
    				$query->expr()->like("replace(CONCAT(replace(replace(c.artmin, ')', ''), '(', ''), c.nccenr), '-', ' ')", "replace(:search, '-', ' ')"),
    				$query->expr()->like("replace(CONCAT(replace(replace(c.artmin, ')', ' '), '(', ''), c.nccenr), '-', ' ')", "replace(:search, '-', ' ')")
    			)
    		)
    		->orderBy('c.nccenr', 'ASC')
    		->setParameter('search', '%'.$search.'%')
    		->setParameter('actual', array(City::ACTUAL_ANCIEN_CODE_CHGT_DEP, City::ACTUAL_FRACTION_CANTONALE));
    		
    		$results = $query->getQuery()->getResult();
    		
    		if(count($results) == 1) {
    			return $this->redirectToRoute("app_city", array("id" => $results[0]->getId()));
    		}
    	}
		
    	return $this->render('AppBundle:Default:search.html.twig', array(
    		'results'	=> $results
    	));
    }

    public function departmentAction(Request $request)
    {
    	$em = $this->getDoctrine()->getManager();
    	$repoDepartment = $em->getRepository("AppBundle:Department");
    	$department = $repoDepartment->find($request->get("id"));
    	
    	// Redirect to the latest election
    	if($department != null) {
    		
    		if(count($department->getResults()) > 0)
    			return $this->redirectToRoute("app_election_department", array(
    					"election_id"	=> $department->getResults()[count($department->getResults())-1]->getRound()->getElection()->getId(),
    					"department_id"		=> $department->getId()
    				)
    			);
    	}
    	 
    	return $this->render('AppBundle:Default:department.html.twig', array(
			'department' => $department,
    	));
    }

    public function cityAction(Request $request)
    {
    	$em = $this->getDoctrine()->getManager();
    	$repoCity = $em->getRepository("AppBundle:City");
    	$city = $repoCity->find($request->get("id"));
    	
    	// Redirect to the latest election
    	if($city != null) {
    		
    		if(count($city->getResults()) > 0)
    			return $this->redirectToRoute("app_election_city", array(
    					"election_id"	=> $city->getResults()[count($city->getResults())-1]->getRound()->getElection()->getId(),
    					"city_id"		=> $city->getId()
    				)
    			);
    	}
    	 
    	return $this->render('AppBundle:Default:city.html.twig', array(
			'city' => $city,
    	));
    }
    
    public function electionDepartmentAction(Request $request)
    {
    	$em = $this->getDoctrine()->getManager();
    	$repoDepartment = $em->getRepository("AppBundle:Department");
    	$repoElection = $em->getRepository("AppBundle:Election");
    	$repoResultDepartment = $em->getRepository("AppBundle:ResultDepartment");
    	$election = $repoElection->find($request->get("election_id"));
    	$previousElection = null;
    	$nextElection = null;
    	$results = array();
    	
    	$department = null;
    	if(!empty($request->get('department_code'))) {
    		$departmentCode = $request->get('department_code');
    		if($this->startsWith($departmentCode, "0")) {
    			$departmentCode = substr($departmentCode, 1, strlen($departmentCode)-1);
    		}
    		
    		$department = $repoDepartment->findOneByDep($departmentCode);
    	}
    	else
    		$department = $repoDepartment->find($request->get("department_id"));
    	
    	if($department != null && $election != null) {

    		$results = $repoResultDepartment->createQueryBuilder("rd")
    		->join("rd.round", "r")
    		->select("rd")
    		->where("r.election = :election")
    		->andWhere("rd.department = :department")
    		->orderBy("r.roundNumber", "DESC")
    		->setParameter("election", $election)
    		->setParameter("department", $department)
    		->getQuery()
    		->getResult();
    		
    		if(count($election->getRounds()) != 0) {
    			
    			$previousElection = $repoElection->createQueryBuilder("e")
    			->join("e.rounds", "r")
    			->select("e")
    			->join("r.resultsDepartment", "rd")
    			->where("e.type = :type")
    			->andWhere("r.roundNumber = 1")
    			->andWhere("rd.department = :department")
    			->andWhere("r.date < :date")
    			->andWhere("e != :election")
    			->setParameter("type", $election->getType())
    			->setParameter("department", $department)
    			->setParameter("date", $election->getRounds()[0]->getDate())
    			->setParameter("election", $election)
    			->orderBy("r.date", "DESC")
    			->setMaxResults(1)
    			->getQuery()
    			->getOneOrNullResult();
    			 
    			$nextElection = $repoElection->createQueryBuilder("e")
    			->join("e.rounds", "r")
    			->select("e")
    			->join("r.resultsDepartment", "rd")
    			->where("e.type = :type")
    			->andWhere("r.roundNumber = 1")
    			->andWhere("rd.department = :department")
    			->andWhere("r.date > :date")
    			->andWhere("e != :election")
    			->setParameter("type", $election->getType())
    			->setParameter("department", $department)
    			->setParameter("date", $election->getRounds()[0]->getDate())
    			->setParameter("election", $election)
    			->orderBy("r.date", "ASC")
    			->setMaxResults(1)
    			->getQuery()
    			->getOneOrNullResult();
    		}
    		
    	}
    
    	return $this->render('AppBundle:Default:election_department.html.twig', array(
    		'department'		=> $department,
    		'election'			=> $election,
    		'results'			=> $results,
    		'previousElection'	=> $previousElection,
    		'nextElection'		=> $nextElection
    	));
    }
    
    public function electionCityAction(Request $request)
    {
    	$em = $this->getDoctrine()->getManager();
    	$repoCity = $em->getRepository("AppBundle:City");
    	$repoElection = $em->getRepository("AppBundle:Election");
    	$repoResultCity = $em->getRepository("AppBundle:ResultCity");
    	$city = $repoCity->find($request->get("city_id"));
    	$election = $repoElection->find($request->get("election_id"));
    	$previousElection = null;
    	$nextElection = null;
    	$results = array();
    	
    	if($city != null && $election != null) {

    		$results = $repoResultCity->createQueryBuilder("rc")
    		->join("rc.round", "r")
    		->select("rc")
    		->where("r.election = :election")
    		->andWhere("rc.city = :city")
    		->orderBy("r.roundNumber", "DESC")
    		->setParameter("election", $election)
    		->setParameter("city", $city)
    		->getQuery()
    		->getResult();
    		
    		if(count($election->getRounds()) != 0) {
    			
    			$previousElection = $repoElection->createQueryBuilder("e")
    			->join("e.rounds", "r")
    			->select("e")
    			->join("r.resultsCity", "rc")
    			->where("e.type = :type")
    			->andWhere("r.roundNumber = 1")
    			->andWhere("rc.city = :city")
    			->andWhere("r.date < :date")
    			->andWhere("e != :election")
    			->setParameter("type", $election->getType())
    			->setParameter("city", $city)
    			->setParameter("date", $election->getRounds()[0]->getDate())
    			->setParameter("election", $election)
    			->orderBy("r.date", "DESC")
    			->setMaxResults(1)
    			->getQuery()
    			->getOneOrNullResult();
    			 
    			$nextElection = $repoElection->createQueryBuilder("e")
    			->join("e.rounds", "r")
    			->select("e")
    			->join("r.resultsCity", "rc")
    			->where("e.type = :type")
    			->andWhere("r.roundNumber = 1")
    			->andWhere("rc.city = :city")
    			->andWhere("r.date > :date")
    			->andWhere("e != :election")
    			->setParameter("type", $election->getType())
    			->setParameter("city", $city)
    			->setParameter("date", $election->getRounds()[0]->getDate())
    			->setParameter("election", $election)
    			->orderBy("r.date", "ASC")
    			->setMaxResults(1)
    			->getQuery()
    			->getOneOrNullResult();
    		}
    		
    	}
    
    	return $this->render('AppBundle:Default:election_city.html.twig', array(
    		'city'				=> $city,
    		'election'			=> $election,
    		'results'			=> $results,
    		'previousElection'	=> $previousElection,
    		'nextElection'		=> $nextElection
    	));
    }
    
    private function startsWith($haystack, $needle)
	{
		$length = strlen($needle);
		return (substr($haystack, 0, $length) === $needle);
	}
}
