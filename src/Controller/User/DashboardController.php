<?php

namespace App\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    /**
     * @Route("/user/dashboard", name="user_dashboard")
     */
    public function index()
    {
        return $this->render('user/dashboard/index.html.twig', [
            'controller_name' => 'DashboardController',
        ]);
    }
}
