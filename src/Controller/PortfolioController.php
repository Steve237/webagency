<?php

namespace App\Controller;

use App\Entity\Project;
use App\Repository\ProjectRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PortfolioController extends AbstractController
{
    /**
     * @Route("/portfolio", name="portfolio")
     */
    public function index(ProjectRepository $projectRepo): Response
    {
        $projects = $projectRepo->findAll();

        return $this->render('portfolio/portfolio.html.twig', [
            
            "projects" => $projects
        ]);
    }


    /**
     * @Route("/project/{id}", name="project")
     */
    public function detailsProjets(Project $project): Response
    {
        return $this->render('portfolio/projet.html.twig', [
           
            "project" => $project

        ]);
    }
}
