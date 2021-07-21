<?php

namespace App\Controller;

use App\Entity\Project;
use App\Form\ContactType;
use App\Repository\ProjectRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(Request $request, \Swift_Mailer $mailer, ProjectRepository $projectRepo): Response
    {

        $project = $projectRepo->findLastProject();

        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()) {

            $contact = $form->getData();

            // On crée le message
            $message = (new \Swift_Message('Nouveau contact'))
                // On attribue l'expéditeur
                ->setFrom($contact['email'])
                // On attribue le destinataire
                ->setTo('essonoadou@gmail.com')
                // On crée le texte avec la vue
                ->setBody(
                    $this->renderView(
                        'emails/contact.html.twig', compact('contact')
                    ),'text/html'
                )
            ;
            
            $mailer->send($message);

            $this->addFlash('success-message', 'Votre message a été transmis, nous vous répondrons dans les meilleurs délais.'); 
                    
            return $this->redirectToRoute('home');
        }   
        
        return $this->render('home/index.html.twig', [
            
            "form" => $form->createView(),
            "project" => $project
        
        
        ]);
    }

}
