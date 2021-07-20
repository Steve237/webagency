<?php

namespace App\Controller;

use App\Entity\Project;
use App\Form\AddProjectType;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminAreaController extends AbstractController
{
    /**
     * @Route("/admin", name="admin_area")
     */
    public function index(ProjectRepository $repoProject): Response
    {
        $projects = $repoProject->findAll();

        return $this->render('admin_area/index.html.twig', [
            
            "projects" => $projects

        ]);
    }

    /**
     * @Route("/admin/add-project", name="add-project")
     */
    public function addProject(Request $request, EntityManagerInterface $entity): Response
    {   
        $project = new Project();

        $form = $this->createForm(AddProjectType::class, $project);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $entity->persist($project);

            $entity->flush();

            $this->addFlash('success', 'Votre vidéo a bien été ajouté');

            return $this->redirectToRoute('admin_area');

        }
        
        return $this->render('admin_area/add-project.html.twig', [
            
            "form" => $form->createView()
        ]);
    }


     /**
     * @Route("/admin/delete-project/{id}", name="delete-project")
     */
    public function deleteProject(Project $project, EntityManagerInterface $entity) {

        
        $entity->remove($project);
        $entity->flush();

        $this->addFlash('success', 'Votre projet a bien été supprimé du portfolio');

        return $this->redirectToRoute('admin_area');

    }
}
