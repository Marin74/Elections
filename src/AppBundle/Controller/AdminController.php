<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Election;
use AppBundle\Entity\Candidate;
use AppBundle\Form\CandidateFormType;
use AppBundle\Form\ElectionFormType;
use AppBundle\Entity\Nuance;
use AppBundle\Form\NuanceFormType;
use AppBundle\Form\CandidacyFormType;
use AppBundle\Entity\Candidacy;
use AppBundle\Entity\ScoreCountry;
use AppBundle\Form\ScoreCountryFormType;

class AdminController extends Controller
{
    public function indexAction(Request $request)
    {
    	$em = $this->getDoctrine()->getManager();
    	$repoElection = $em->getRepository('AppBundle:Election');
    	$repoCandidate = $em->getRepository('AppBundle:Candidate');
    	$elections = $repoElection->findBy(array(), array("name" => "ASC"));
    	$candidates = $repoCandidate->findBy(array(), array("lastname" => "ASC", "firstname" => "ASC"));
    	
        return $this->render('AppBundle:Admin:index.html.twig', array(
        	'elections' => $elections,
        	'candidates' => $candidates,
        ));
    }

    public function candidatesAction(Request $request)
    {
    	$em = $this->getDoctrine()->getManager();
        $translator = $this->get("translator");
    	$repoCandidate = $em->getRepository('AppBundle:Candidate');
    	$newCandidate = new Candidate();
    	$formBuilder = $this->get('form.factory')->createBuilder(CandidateFormType::class, $newCandidate);
    	$form = $formBuilder->getForm();
    	
    	
    	if ($request->isMethod('POST')) {
    		$form->handleRequest($request);
    	
    		// Manage form
    		if($form->isSubmitted()) {
    			if ($form->isValid()) {
    				$em->persist($newCandidate);
    				$em->flush();
    				
    				$formBuilder = $this->get('form.factory')->createBuilder(CandidateFormType::class, new Candidate());
    				$form = $formBuilder->getForm();
    				
    				$request->getSession()->getFlashBag()->add('success', $translator->trans("candidate_added"));
    			}
    		}
    	}

    	$candidates = $repoCandidate->findBy(array(), array("lastname" => "ASC", "firstname" => "ASC"));
    	
    	return $this->render('AppBundle:Admin:candidates.html.twig', array(
    		'candidates' => $candidates,
    		'form' => $form->createView(),
    	));
    }

    public function candidateAction(Request $request)
    {
    	$em = $this->getDoctrine()->getManager();
    	$translator = $this->get("translator");
    	$repoCandidate = $em->getRepository('AppBundle:Candidate');
    	$candidateId = $request->get("id");
    	$candidate = null;
    	$form = null;
    	 
    	if(!empty($candidateId)) {
    		$candidate = $repoCandidate->find($candidateId);
    
    		$formBuilder = $this->get('form.factory')->createBuilder(CandidateFormType::class, $candidate);
    		$form = $formBuilder->getForm();
    
    
    		if ($request->isMethod('POST')) {
    			$form->handleRequest($request);
    
    			// Manage form
    			if($form->isSubmitted()) {
    				if ($form->isValid()) {
    					$em->flush();
    
    					$request->getSession()->getFlashBag()->add('success', $translator->trans("candidate_updated"));
    				}
    			}
    		}
    	}
    	 
    	return $this->render('AppBundle:Admin:candidate.html.twig', array(
    			'candidate' => $candidate,
    			'form' => $form->createView(),
    	));
    }
    
    public function electionsAction(Request $request)
    {
    	$em = $this->getDoctrine()->getManager();
    	$translator = $this->get("translator");
    	$repoElection = $em->getRepository('AppBundle:Election');
    	$newElection = new Election();
    	$formBuilder = $this->get('form.factory')->createBuilder(ElectionFormType::class, $newElection);
    	$form = $formBuilder->getForm();
    	 
    	if ($request->isMethod('POST')) {
    		$form->handleRequest($request);
    		 
    		// Manage form
    		if($form->isSubmitted()) {
    			if ($form->isValid()) {
    				$em->persist($newElection);
    				$em->flush();
    
    				$formBuilder = $this->get('form.factory')->createBuilder(ElectionFormType::class, new Election());
    				$form = $formBuilder->getForm();
    
    				$request->getSession()->getFlashBag()->add('success', $translator->trans("election_added"));
    			}
    		}
    	}
    
    	$elections = $repoElection->findBy(array(), array("name" => "ASC"));
    	 
    	return $this->render('AppBundle:Admin:elections.html.twig', array(
    		'elections' => $elections,
    		'form' => $form->createView(),
    	));
    }

    public function electionAction(Request $request)
    {
    	$em = $this->getDoctrine()->getManager();
    	$translator = $this->get("translator");
    	$repoElection = $em->getRepository('AppBundle:Election');
    	$repoCandidacy = $em->getRepository('AppBundle:Candidacy');
    	$repoScoreCountry = $em->getRepository('AppBundle:ScoreCountry');
    	$electionId = $request->get("id");
    	$election = null;
    	$form = null;
    	$formCandidacy = null;
    	$formScore = null;
    	 
    	if(!empty($electionId)) {
    		$election = $repoElection->find($electionId);

    		// Election form
    		$formBuilder = $this->get('form.factory')->createBuilder(ElectionFormType::class, $election);
    		$form = $formBuilder->getForm();
    		
    		if ($request->isMethod('POST')) {
    			$form->handleRequest($request);
    			 
    			// Manage form
    			if($form->isSubmitted()) {
    				if ($form->isValid()) {
    					
    					$em->flush();

    					$formBuilder = $this->get('form.factory')->createBuilder(ElectionFormType::class, new Election());
    					$form = $formBuilder->getForm();
    		
    					$request->getSession()->getFlashBag()->add('success', $translator->trans("election_updated"));
    				}
    			}
    		}
    		
    		// Candidacy form
    		$candidacy = new Candidacy();
    		//$formBuilder = $this->get('form.factory')->createBuilder(new CandidacyFormType($election), $candidacy);
    		//$formCandidacy = $formBuilder->getForm();
    		$formCandidacy = $this->createForm(CandidacyFormType::class, $candidacy, array(
		        'election_id' => $election,
		    ));
    		
    		if ($request->isMethod('POST')) {
    			$formCandidacy->handleRequest($request);
    		
    			// Manage form
    			if($formCandidacy->isSubmitted()) {
    				if ($formCandidacy->isValid()) {
    					
    					// Check if the candidate is already added to the round
    					$nbDoubloons = $repoCandidacy->createQueryBuilder("c")
    						->select("COUNT(c)")
	    					->where("c.candidate = :candidate")
	    					->andWhere("c.round = :round")
	    					->setParameter("candidate", $candidacy->getCandidate())
	    					->setParameter("round", $candidacy->getRound())
	    					->getQuery()
	    					->getSingleScalarResult();
    					
	    				if(intval($nbDoubloons) > 0)
    						$request->getSession()->getFlashBag()->add('warning', $translator->trans("candidate_already_added"));
    					else {

    						$em->persist($candidacy);
    						$em->flush();
    						
    						$formCandidacy = $this->createForm(CandidacyFormType::class, new Candidacy(), array(
    							'election_id' => $election,
    						));
    						
    						$request->getSession()->getFlashBag()->add('success', $translator->trans("candidacy_added"));
    					}
    				}
    			}
    		}
    		
    		// Score form
    		$score = new ScoreCountry();
    		$formScore = $this->createForm(ScoreCountryFormType::class, $score, array(
		        'election_id' => $election,
		    ));
    		
    		if ($request->isMethod('POST')) {
    			$formScore->handleRequest($request);
    		
    			// Manage form
    			if($formScore->isSubmitted()) {
    				if ($formScore->isValid()) {

    					$score->setResult($score->getCandidacy()->getRound()->getResultCountry());
    					
    					// Check if the score is already added
    					$nbDoubloons = $repoScoreCountry->createQueryBuilder("sc")
	    					->select("COUNT(sc)")
	    					->where("sc.candidacy = :candidacy")
	    					->andWhere("sc.result = :result")
	    					->setParameter("candidacy", $score->getCandidacy())
	    					->setParameter("result", $score->getResult())
	    					->getQuery()
	    					->getSingleScalarResult();
    					
    					if(intval($nbDoubloons) > 0)
    						$request->getSession()->getFlashBag()->add('warning', $translator->trans("score_already_added"));
    					else {

    						$em->persist($score);
    						$em->flush();
    						
    						$formScore = $this->createForm(ScoreCountryFormType::class, new ScoreCountry(), array(
    							'election_id' => $election,
    						));
    						
    						$request->getSession()->getFlashBag()->add('success', $translator->trans("score_added"));
    					}
    				}
    			}
    		}
    	}
    	
    	return $this->render('AppBundle:Admin:election.html.twig', array(
    		'election' => $election,
    		'form' => $form->createView(),
    		'formCandidacy' => $formCandidacy->createView(),
    		'formScore' => $formScore->createView(),
    	));
    }
    
    public function nuancesAction(Request $request)
    {
    	$em = $this->getDoctrine()->getManager();
    	$translator = $this->get("translator");
    	$repoNuance = $em->getRepository('AppBundle:Nuance');
    	$newNuance = new Nuance();
    	$formBuilder = $this->get('form.factory')->createBuilder(NuanceFormType::class, $newNuance);
    	$form = $formBuilder->getForm();
    
    	if ($request->isMethod('POST')) {
    		$form->handleRequest($request);
    		 
    		// Manage form
    		if($form->isSubmitted()) {
    			if ($form->isValid()) {
    				$em->persist($newNuance);
    				$em->flush();
    
    				$formBuilder = $this->get('form.factory')->createBuilder(NuanceFormType::class, new Nuance());
    				$form = $formBuilder->getForm();
    
    				$request->getSession()->getFlashBag()->add('success', $translator->trans("nuance_added"));
    			}
    		}
    	}
    
    	$nuances = $repoNuance->findBy(array(), array("code" => "ASC"));
    
    	return $this->render('AppBundle:Admin:nuances.html.twig', array(
    			'nuances' => $nuances,
    			'form' => $form->createView(),
    	));
    }
    
    public function nuanceAction(Request $request)
    {
    	$em = $this->getDoctrine()->getManager();
    	$translator = $this->get("translator");
    	$repoNuance = $em->getRepository('AppBundle:Nuance');
    	$nuanceId = $request->get("id");
    	$nuance = null;
    	$form = null;
    
    	if(!empty($nuanceId)) {
    		$nuance = $repoNuance->find($nuanceId);
    
    		$formBuilder = $this->get('form.factory')->createBuilder(NuanceFormType::class, $nuance);
    		$form = $formBuilder->getForm();
    
    		if ($request->isMethod('POST')) {
    			$form->handleRequest($request);
    
    			// Manage form
    			if($form->isSubmitted()) {
    				if ($form->isValid()) {
    					$em->persist($nuance);
    					$em->flush();
    
    					$request->getSession()->getFlashBag()->add('success', $translator->trans("nuance_updated"));
    				}
    			}
    		}
    	}
    
    	return $this->render('AppBundle:Admin:nuance.html.twig', array(
    			'nuance' => $nuance,
    			'form' => $form->createView(),
    	));
    }
}
