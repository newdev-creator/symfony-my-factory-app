<?php

namespace App\Controller\Worker;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class WorkerDashboardController extends AbstractController
{
    #[Route('/worker/dashboard', name: 'worker_dashboard_index')]
    public function index(): Response
    {
        return $this->render('worker/worker_dashboard/index.html.twig', [
            'controller_name' => 'WorkerDashboardController',
        ]);
    }
}
