<?php

namespace ElectionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class DefaultController extends Controller
{
    public function indexAction()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $repoElectionRound = $entityManager->getRepository("ElectionBundle:ElectionRound");
        $repoResult = $entityManager->getRepository("ElectionBundle:Result");

        $lastElectionRound = $repoElectionRound->findOneBy(array(), array("date" => "asc"));

        return $this->render('ElectionBundle:Default:index.html.twig', array(
            "mapResults" => $repoResult->findBy(array("town" => null, "electionRound" => $lastElectionRound)),
        ));
    }

    public function searchAction()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $repoTown = $entityManager->getRepository("ElectionBundle:Town");
        $repoDepartment = $entityManager->getRepository("ElectionBundle:Department");
        $repoElection = $entityManager->getRepository("ElectionBundle:Election");
        $request = Request::createFromGlobals();

        $search = $request->request->get("search");

        $election = $repoElection->findOneBy(array(), array("id" => "desc"));

        $town = $repoTown->findOneBy(array("name" => $search));

        if($town != null)
            return $this->redirect($this->generateUrl('election_town', array("id" => $election->getId(), "code" => $town->getId())));

        $department = $repoDepartment->findOneBy(array("name" => $search));

        if($department != null)

        return $this->render('ElectionBundle:Default:search.html.twig');
    }

    public function electionsAction()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $repoElection = $entityManager->getRepository("ElectionBundle:Election");

        return $this->render('ElectionBundle:Default:elections.html.twig', array(
            "elections" => $repoElection->findAll(),
        ));
    }

    public function electionAction($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $repoElection = $entityManager->getRepository("ElectionBundle:Election");

        return $this->render('ElectionBundle:Default:election.html.twig', array(
            "election" => $repoElection->find($id),
        ));
    }

    public function departmentAction($id, $code)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $repoElection = $entityManager->getRepository("ElectionBundle:Election");
        $repoElectionRound = $entityManager->getRepository("ElectionBundle:ElectionRound");
        $repoDepartment = $entityManager->getRepository("ElectionBundle:Department");
        $repoResult = $entityManager->getRepository("ElectionBundle:Result");
        $repoTown = $entityManager->getRepository("ElectionBundle:Town");

        $results = array();// Get results of the election for the selected department
        $mapResults = array();// Get results of the towns

        $election = $repoElection->find($id);
        $department = $repoDepartment->findOneBy(array("code" => $code));

        if($election != null && $department != null) {
            foreach ($election->getElectionRounds() as $electionRound) {
                $result = $repoResult->findOneBy(array("electionRound" => $electionRound, "department" => $department));

                if ($result != null)
                    $results[] = $result;
            }

            $lastRound = $repoElectionRound->findOneBy(array("election" => $election), array("date" => "desc"));

            $towns = $repoTown->findBy(array("department" => $department));
            foreach ($towns as $town) {
                foreach ($town->getResults() as $tempResult) {
                    if ($tempResult->getElectionRound()->getId() == $lastRound->getId())
                        $mapResults[] = $tempResult;
                }
            }
        }

        return $this->render('ElectionBundle:Default:department.html.twig', array(
            "department" => $department,
            "results" => $results,
            "mapResults" => $mapResults,
        ));
    }

    public function townAction($id, $code)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $repoElection = $entityManager->getRepository("ElectionBundle:Election");
        $repoResult = $entityManager->getRepository("ElectionBundle:Result");
        $repoTown = $entityManager->getRepository("ElectionBundle:Town");
        $repoDepartment = $entityManager->getRepository("ElectionBundle:Department");

        $town = null;
        $results = array();// Get results of the election for the selected town

        $depCode = $code[0] . $code[1];
        if (strlen($code) == 5) {
            if ($code[2] == "0")
                $code = $code[3] . $code[4];
            else
                $code = $code[2] . $code[3] . $code[4];
        }

        $election = $repoElection->find($id);
        $department = $repoDepartment->findOneBy(array("code" => $depCode));

        if ($department != null) {
            $town = $repoTown->findOneBy(array("code" => $code, "department" => $department));

            if ($election != null && $town != null) {
                foreach ($election->getElectionRounds() as $electionRound) {
                    $result = $repoResult->findOneBy(array("electionRound" => $electionRound, "town" => $town));

                    if ($result != null)
                        $results[] = $result;
                }
            }
        }

        return $this->render('ElectionBundle:Default:town.html.twig', array(
            "town" => $town,
            "results" => $results,
        ));
    }
}
