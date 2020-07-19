<?php

namespace App\Controller\User;

use App\Repository\CommentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    /**
     * @Route("/user/dashboard", name="user_dashboard")
     * @param CommentRepository $commentRepository
     * @return Response
     */
    public function index(CommentRepository $commentRepository)
    {

        return $this->render('user/dashboard/index.html.twig', [
            'articlesCommented' => count($commentRepository->findByUser($this->getUser()))
        ]);
    }
}
