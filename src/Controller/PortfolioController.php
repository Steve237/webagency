<?php

namespace App\Controller;

use App\Entity\Project;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PortfolioController extends AbstractController
{
    /**
     * @Route("/portfolio", name="portfolio")
     */
    public function index(): Response
    {

        return $this->render('portfolio/portfolio.html.twig', [
            'controller_name' => 'PortfolioController',
        ]);
    }


    /**
     * @Route("/project/{slug}", name="project")
     */
    public function detailsProjets(Project $project): Response
    {
        return $this->render('portfolio/projet.html.twig', [
           
            "project" => $project

        ]);
    }
}
