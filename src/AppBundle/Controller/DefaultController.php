<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\ElectionType;
use AppBundle\Entity\City;
use AppBundle\Entity\Department;
use AppBundle\Entity\ResultDepartment;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
    	$em = $this->getDoctrine()->getManager();
    	$repoElectionRound = $em->getRepository("AppBundle:ElectionRound");
    	$roundNumber = $request->get("roundNumber");
    	$round = null;
    	if(!empty($roundNumber))
    		$round = $repoElectionRound->findOneBy(array("roundNumber" => $roundNumber), array("date" => "DESC"));
    	
    	if($round == null)
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
    	$resultsDepartment = array();
    	
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
	    		
	    		$roundNumber = $request->get("roundNumber");
	    		
	    		if(!empty($roundNumber)) {
	    			
	    			foreach($election->getRounds() as $round) {
	    				
	    				if($round->getRoundNumber() == intval($roundNumber)) {
	    					
	    					$resultsDepartment = $round->getResultsDepartment();
	    					break;
	    				}
	    			}
	    		}
	    		
	    		if(count($resultsDepartment) == 0) {
	    			$resultsDepartment = $election->getRounds()[0]->getResultsDepartment();
	    		}
    		}
    	}
    	
        return $this->render('AppBundle:Default:election.html.twig', array(
        	'election'			=> $election,
        	'resultsDepartment'	=> $resultsDepartment,
        	'previousElection'	=> $previousElection,
        	'nextElection'		=> $nextElection
        ));
    }
    
    public function searchAction(Request $request)
    {
    	$em = $this->getDoctrine()->getManager();
    	$repoCity = $em->getRepository("AppBundle:City");
    	$repoDepartment = $em->getRepository("AppBundle:Department");
    	$repoElection = $em->getRepository("AppBundle:Election");
    	$search = trim($request->get("q"));
    	$cities = array();
    	$departments = array();
    	$elections = array();
    	
    	if(!empty($search)) {
    		
    		// Cities
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
    		
    		$cities = $query->getQuery()->getResult();
			
    		// Departments
    		$query = $repoDepartment->createQueryBuilder('d');
    		$query
    		->where($query->expr()->like("replace(d.nccenr, '-', ' ')", "replace(:search, '-', ' ')"))
    		->orderBy('d.nccenr', 'ASC')
    		->setParameter('search', '%'.$search.'%');
    		
    		$departments = $query->getQuery()->getResult();
			
    		// Elections
    		$query = $repoElection->createQueryBuilder('e');
    		$query
    		->where($query->expr()->like("e.name", ":search"))
    		->orderBy('e.name', 'DESC')
    		->setParameter('search', '%'.$search.'%');
    		
    		$elections = $query->getQuery()->getResult();
    		


    		if(count($cities) == 1 && count($departments) == 0 && count($elections) == 0) {
    			return $this->redirectToRoute("app_city", array("id" => $cities[0]->getId(), "name" => $cities[0]->getURLName()));
    		}
    		elseif(count($cities) == 0 && count($departments) == 1 && count($elections) == 0) {
    			return $this->redirectToRoute("app_department", array("id" => $departments[0]->getId(), "name" => $departments[0]->getURLName()));
    		}
    		elseif(count($cities) == 0 && count($departments) == 0 && count($elections) == 1) {
    			return $this->redirectToRoute("app_election", array("id" => $elections[0]->getId(), "name" => $elections[0]->getURLName()));
    		}
    	}
		
    	return $this->render('AppBundle:Default:search.html.twig', array(
    		'cities'		=> $cities,
    		'departments'	=> $departments,
    		'elections'		=> $elections,
    		'search'		=> $search
    	));
    }

    public function departmentAction(Request $request)
    {
    	$em = $this->getDoctrine()->getManager();
    	$repoDepartment = $em->getRepository("AppBundle:Department");
    	$department = $repoDepartment->find($request->get("id"));
    	
    	// Redirect to the latest election
    	if($department != null) {
    		
    		if(count($department->getResults()) > 0) {
    			
    			// Get the most recent election
    			$election = null;
    			$electionDate = null;
    			 
    			foreach($department->getResults() as $result) {
    			
    				if($election == null || $result->getRound()->getDate() > $electionDate) {
    						
    					$election = $result->getRound()->getElection();
    					$electionDate = $result->getRound()->getDate();
    				}
    			}
    			 
    			return $this->redirectToRoute("app_election_department", array(
						"election_id"	=> $election->getId(),
						"department_id"	=> $department->getId(),
    					"name"			=> $election->getURLName()."-".$department->getURLName()
					)
				);
    		}
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
    		
    		if(count($city->getResults()) > 0) {
    			
    			// Get the most recent election
    			$election = null;
    			$electionDate = null;
    			
    			foreach($city->getResults() as $result) {
    				
    				if($election == null || $result->getRound()->getDate() > $electionDate) {
    					
    					$election = $result->getRound()->getElection();
    					$electionDate = $result->getRound()->getDate();
    				}
    			}
    			
    			return $this->redirectToRoute("app_election_city", array(
    					"election_id"	=> $election->getId(),
    					"city_id"		=> $city->getId(),
    					"name"			=> $election->getURLName()."-".$city->getURLName()
    				)
    			);
    		}
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
    	$repoElectionRound = $em->getRepository("AppBundle:ElectionRound");
    	$repoResultCity = $em->getRepository("AppBundle:ResultCity");
    	$repoResultDepartment = $em->getRepository("AppBundle:ResultDepartment");
    	$election = $repoElection->find($request->get("election_id"));
    	$previousElection = null;
    	$nextElection = null;
    	$results = array();
    	$resultsCity = array();
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
    			
    			$roundNumber = $request->get("roundNumber");
    			
    			if(!empty($roundNumber)) {
    				
    				$round = $repoElectionRound->findOneBy(array("election" => $election, "roundNumber" => $roundNumber));
    				
    				if($round != null) {
	    				$resultsCity = $repoResultCity->createQueryBuilder("rc")
	    				->join("rc.city", "c")
	    				->select("rc")
	    				->where("c.department = :department")
	    				->andWhere("rc.round = :round")
	    				->setParameter("round", $round)
	    				->setParameter("department", $department)
	    				->getQuery()
	    				->getResult();
    				}
    			}
				
    			$i = 0;
    			while(count($resultsCity) == 0 && $i < count($election->getRounds())) {
    			
    				$resultsCity = $repoResultCity->createQueryBuilder("rc")
    				->join("rc.city", "c")
    				->select("rc")
    				->where("c.department = :department")
    				->andWhere("rc.round = :round")
    				->setParameter("round", $election->getRounds()[$i])// TODO
    				->setParameter("department", $department)
    				->getQuery()
    				->getResult();
    					
    				$i++;
    			}
    			
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
    		'resultsCity'		=> $resultsCity,
    		'previousElection'	=> $previousElection,
    		'nextElection'		=> $nextElection
    	));
    }
    
    public function electionCityAction(Request $request)
    {
    	$em = $this->getDoctrine()->getManager();
    	$repoCity = $em->getRepository("AppBundle:City");
    	$repoElection = $em->getRepository("AppBundle:Election");
    	$repoDepartment = $em->getRepository("AppBundle:Department");
    	$repoResultCity = $em->getRepository("AppBundle:ResultCity");
    	$election = $repoElection->find($request->get("election_id"));
    	$previousElection = null;
    	$nextElection = null;
    	$results = array();
    	$city = null;
    	
    	if(!empty($request->get('city_code'))) {
			
    		$cityCode = $request->get('city_code');
    		
    		// Get department code
    		$departmentCode = substr($cityCode, 0, 2);
    		if($this->startsWith($cityCode, "0")) {
    			$departmentCode = substr($departmentCode, 1, strlen($departmentCode)-1);
    		}
    		
    		$department = $repoDepartment->findOneByDep($departmentCode);
    		
    		if($department != null) {
    			
    			$cityCode = substr($cityCode, 2);
    			
    			// Get city code
    			if($this->startsWith($cityCode, "0")) {
    				$cityCode = substr($cityCode, 1, strlen($cityCode)-1);
    				 
    				if($this->startsWith($cityCode, "0")) {
    					$cityCode = substr($cityCode, 1, strlen($cityCode)-1);
    				}
    			}
    			
    			//$city = $repoCity->findOneBy(array("department" => $department, "com" => $cityCode));
    			
    			// Search city
    			$query = $repoCity->createQueryBuilder('c');
    			$query->where($query->expr()->notIn("c.actual", ":actual"))
    			->andWhere($query->expr()->eq("c.department", ":department"))
    			->andWhere($query->expr()->eq("c.com", ":com"))
    			->setParameter('actual', array(City::ACTUAL_ANCIEN_CODE_CHGT_DEP, City::ACTUAL_FRACTION_CANTONALE))
    			->setParameter("department", $department)
    			->setParameter("com", $cityCode);
    			
				$cities = $query->getQuery()->getResult();
				
				if(count($cities) > 0) {
					$city = $cities[0];
				}
    		}
    	}
    	else
    		$city = $repoCity->find($request->get("city_id"));
    	
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

    public function contactAction(Request $request)
    {
		$emailAddress = $request->get("email");
		$body = $request->get("body");
		
		if($request->getMethod() == "POST" && !empty(trim($emailAddress)) && !empty(trim($body))) {
			
			$translator = $this->get('translator');
			
			$appName = $this->getParameter("app_name");
			$subject = $translator->trans("contact_subject", array("%app_name%" => $appName, "%email%" => $emailAddress));
			
			$email = \Swift_Message::newInstance();
			$email->setSubject($subject);
			$email->setFrom($emailAddress);
			$email->setTo($this->container->getParameter("mailer_user"));
			$email->setBody($body);
			$email->setContentType("text/html");
			$this->get("mailer")->send($email);
			
			$this->get("session")->getFlashBag()->add("success", $translator->trans("mail_sent"));
		}
		
		return $this->render('AppBundle:Default:contact.html.twig');
    }
    
    public function candidateAction(Request $request)
    {
    	$em = $this->getDoctrine()->getManager();
    	$repoCandidate = $em->getRepository("AppBundle:Candidate");
    	$candidate = $repoCandidate->find($request->get("id"));
    	
    	return $this->render('AppBundle:Default:candidate.html.twig', array(
    			'candidate'	=> $candidate,
    	));
    }
    
    private function startsWith($haystack, $needle)
	{
		$length = strlen($needle);
		return (substr($haystack, 0, $length) === $needle);
	}
}
