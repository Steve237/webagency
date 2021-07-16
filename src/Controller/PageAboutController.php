<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PageAboutController extends AbstractController
{
    /**
     * @Route("/about-us", name="about-us")
     */
    public function index(): Response
    {
        return $this->render('page_about/index.html.twig', [
            'controller_name' => 'PageAboutController',
        ]);
    }
}
