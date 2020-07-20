<?php

namespace App\Controller\Admin;

use App\Repository\ArticleRepository;
use App\Repository\CommentRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    /**
     * @Route("/admin", name="admin_dashboard_index")
     * @param UserRepository $userRepository
     * @param ArticleRepository $articleRepository
     * @param CommentRepository $commentRepository
     * @return Response
     */
    public function index(UserRepository $userRepository, ArticleRepository $articleRepository, CommentRepository $commentRepository) : Response
    {
        return $this->render('admin/dashboard/index.html.twig', [
            'controller_name' => 'DashboardController',
            'usersCount' => $userRepository->count([]),
            'articlesCount' => $articleRepository->count([]),
            'commentsCount' => $commentRepository->count([])
        ]);
    }
}
