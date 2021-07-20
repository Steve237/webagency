<?php

namespace App\Controller;

use App\Entity\Project;
use App\Form\AddProjectType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminAreaController extends AbstractController
{
    /**
     * @Route("/admin", name="admin_area")
     */
    public function index(): Response
    {

        return $this->render('admin_area/index.html.twig', [
            
        ]);
    }



    /**
     * @Route("/add-project", name="add-project")
     */
    public function addProject(): Response
    {   
        $project = new Project();

        $form = $this->createForm(AddProjectType::class, $project);


        return $this->render('admin_area/add-project.html.twig', [
            
            "form" => $form->createView()
        ]);
    }
}
