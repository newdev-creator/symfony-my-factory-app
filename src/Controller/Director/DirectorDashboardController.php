<?php

namespace App\Controller\Director;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DirectorDashboardController extends AbstractController
{
    #[Route('/director/dashboard', name: 'director_dashboard_index')]
    public function index(): Response
    {
        return $this->render('director/director_dashboard/index.html.twig', [
            'controller_name' => 'DirectorDashboardController',
        ]);
    }
}
