<?php

namespace App\Controller;

use App\Entity\Project;
use App\Form\AddProjectType;
use App\Form\UpdateProjectType;
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
     * Liste des projets dans la page admin
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
     * Permet d'ajouter un projet
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

            $this->addFlash('success', 'Votre vidéo a bien été ajouté.');

            return $this->redirectToRoute('admin_area');

        }
        
        return $this->render('admin_area/add-project.html.twig', [
            
            "form" => $form->createView()
        ]);
    }


    /**
     * Permet de modifier un projet
     * @Route("/admin/update-project/{id}", name="update-project")
     */
    public function updateProject(Project $project, Request $request, EntityManagerInterface $entity): Response
    {   

        $form = $this->createForm(UpdateProjectType::class, $project);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

             // On récupère l'image principale et on l'envoie dans le dossier images
             $mainImage = $form->get('image')->getData();

            if(!empty($mainImage)) {

                $fileImage = md5(uniqid()).'.'.$mainImage->guessExtension();

                $extension = pathinfo($fileImage, PATHINFO_EXTENSION);

                if($extension != "jpg" AND $extension != "jpeg" AND $extension != "png") {

                    $this->addFlash('invalid-image', 'Ajouter une image au format jpg, jpeg, ou png');

                    $projectId = $project->getId();

                    return $this->redirectToRoute('update-project', ['id' => $projectId]);

                }   
                
                $mainImage->move($this->getParameter('image_directory'), $fileImage);

                $project->SetCoverImage($fileImage);

            }

            $entity->persist($project);
            $entity->flush();

            $this->addFlash('success', 'Votre projet a bien été modifié.');

            return $this->redirectToRoute('admin_area');

        }
        
        return $this->render('admin_area/update-project.html.twig', [
            
            "form" => $form->createView()
        ]);
    }


    /**
      * Permet de supprimer un projet
     * @Route("/admin/delete-project/{id}", name="delete-project")
     */
    public function deleteProject(Project $project, EntityManagerInterface $entity) {

        $entity->remove($project);
        $entity->flush();

        $this->addFlash('success', 'Votre projet a bien été supprimé du portfolio.');

        return $this->redirectToRoute('admin_area');

    }






}
