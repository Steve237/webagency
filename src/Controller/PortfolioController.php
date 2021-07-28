<?php

namespace App\Controller;

use App\Entity\Project;
use App\Repository\ProjectRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PortfolioController extends AbstractController
{
    /**
     * @Route("/portfolio", name="portfolio")
     */
    public function index(ProjectRepository $projectRepo, PaginatorInterface $paginator, Request $request): Response
    {

        $projectsList = $projectRepo->findAll();

        $projects = $paginator->paginate(
            $projectsList, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            20 /*limit per page*/
        );

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
