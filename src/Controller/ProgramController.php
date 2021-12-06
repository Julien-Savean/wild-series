<?php
// src/Controller/ProgramController.php
namespace App\Controller;

use App\Entity\Episode;
use App\Entity\Program;
use App\Entity\Season;
use App\Form\ProgramType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/program", name="program_")
 */
class ProgramController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        $programs = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findAll();

        return $this->render(
            'program/index.html.twig', 
            ['programs' => $programs]
        );
    }
    
    /**
     * The controller for the program add form
     *
     * @Route("/new", name="new")
     */
    public function new(Request $request) : Response
    {
        // Create a new Program Object
        $Program = new Program();
        // Create the associated Form
        $form = $this->createForm(ProgramType::class, $Program);
        // Get data from HTTP request
        $form->handleRequest($request);
        // Was the form submitted ?
        if ($form->isSubmitted()) {
            // Deal with the submitted data
            // Get the Entity Manager
            $entityManager = $this->getDoctrine()->getManager();
            // Persist Program Object
            $entityManager->persist($Program);
            // Flush the persisted object
            $entityManager->flush();
            // Finally redirect to programs list
            return $this->redirectToRoute('program_index');
        }
        // Render the form
        return $this->render('program/new.html.twig', ["form" => $form->createView()]);
    }
    
    /**
     * @Route("/{id}/", methods={"GET"},  name="show")
     */
    public function show(Program $program): Response
    {
        $seasons = $this->getDoctrine()
        ->getRepository(Season::class)
        ->findBy(
            ['program' => $program],
            ['number' => 'ASC'],
        ); 

        return $this->render('program/show.html.twig', [
            'program' => $program,
            'seasons' => $seasons,
        ]);
    }

    /**
     * @Route("/{program}/season/{season}", methods={"GET"},  name="season_show")
     */
    public function showSeason(Program $program, Season $season): Response
    {
        $episodes = $this->getDoctrine()
        ->getRepository(Episode::class)
        ->findBy(
            ['season' => $season],
            ['number' => 'ASC'],
        );
       
        if (!$season) {
            throw $this->createNotFoundException(
                'No season with id : '.$season.' found in program\'s table.'
            );
        }
        return $this->render('program/season_show.html.twig', [
            'program' => $program,
            'season' => $season,
            'episodes' => $episodes,
        ]);
    }

    /**
     * @Route("/{program}/season/{season}/episode/{episode}", methods={"GET"},  name="episode_show")
     */
    public function showEpisode(Program $program, Season $season, Episode $episode)
    {
            return $this->render('program/episode_show.html.twig', [
            'program' => $program,
            'season' => $season,
            'episode' => $episode,
        ]);
    }

    
}