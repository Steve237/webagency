<?php

namespace App\Controller;

use App\Entity\Project;
use App\Form\AddProjectType;
use App\Form\UpdateProjectType;
use Doctrine\ORM\EntityManager;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
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
     * Permet d'ajouter un projet
     * @Route("/admin/add-project", name="add-project")
     */
    public function addProject(Request $request, EntityManagerInterface $entity): Response
    {   
        $project = new Project();

        $form = $this->createForm(AddProjectType::class, $project);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            // On récupère l'image principale et on l'envoie dans le dossier images
            $mainImage = $form->get('coverimage')->getData();
            $fileImage = md5(uniqid()).'.'.$mainImage->guessExtension();

            // On vérifie l'extension de l'image
            $extension = pathinfo($fileImage, PATHINFO_EXTENSION);

            if($extension != "jpg" && $extension && "jpeg" && $extension != "png") {

                $this->addFlash('invalid-images', 'Please upload images in format jpg, jpêg, png.');


                return $this->redirectToRoute('add-product', ['id' => $category->getId()]);
            
            }
            
            $mainImage->move($this->getParameter('image_directory'), $fileImage);

            $project->setCoverImage($fileImage);
            
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
        // image de couverture en base de données
        $image = $project->getCoverimage();

        $form = $this->createForm(UpdateProjectType::class, $project);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

             // On récupère l'image principale et on l'envoie dans le dossier images
             $mainImage = $form->get('coverimage')->getData();

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

            } else {

                // On remet l'image de couverture initiale si il laisse le champ image vide
                $project->SetCoverImage($image);

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

        $coverImage = $project->getCoverimage();
        $coverPath = 'assets/img/project/'.$coverImage;
        unlink($coverPath);

        $entity->remove($project);
        $entity->flush();

        $this->addFlash('success', 'Votre projet a bien été supprimé du portfolio.');

        return $this->redirectToRoute('admin_area');

    }
}
