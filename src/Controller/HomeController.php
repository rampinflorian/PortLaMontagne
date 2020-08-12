<?php

namespace App\Controller;

use App\Repository\AlertRepository;
use App\Repository\ArticleRepository;
use App\Repository\CommentRepository;
use App\Repository\PartnerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @param ArticleRepository $articleRepository
     * @param PartnerRepository $partnerRepository
     * @param ParameterBagInterface $parameterBag
     * @param CommentRepository $commentRepository
     * @return Response
     */
    public function index(ArticleRepository $articleRepository, PartnerRepository $partnerRepository, ParameterBagInterface $parameterBag, CommentRepository $commentRepository)
    {
        return $this->render('home/index.html.twig', [
            'countArticles' => $articleRepository->count([]),
            'countArticlesComments' => $commentRepository->count([]),
            'articles' => $articleRepository->FindLastActiveWithMaxResult(4),
            'partners' => $partnerRepository->findAll(),
            'partners_directory' => $parameterBag->get('partner_directory')
        ]);
    }
}
