<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminAreaController extends AbstractController
{
    /**
     * @Route("/admin", name="admin_area")
     */
    public function index(): Response
    {
        return $this->render('admin_area/index.html.twig', [
            'controller_name' => 'AdminAreaController',
        ]);
    }
}
