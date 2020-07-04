<?php

namespace App\Controller;

use App\Repository\AlertRepository;
use App\Repository\ArticleRepository;
use App\Repository\ClimbingGroupRepository;
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
     * @param ClimbingGroupRepository $climbingGroupRepository
     * @param ParameterBagInterface $parameterBag
     * @return Response
     */
    public function index(ArticleRepository $articleRepository, PartnerRepository $partnerRepository, ClimbingGroupRepository $climbingGroupRepository, ParameterBagInterface $parameterBag)
    {
        return $this->render('home/index.html.twig', [
            'countArticles' => count($articleRepository->findAll()),
            'articles' => $articleRepository->findAllWithMaxResult(4),
            'countGroups' => count($climbingGroupRepository->findAll()),
            'partners' => $partnerRepository->findAll(),
            'partners_directory' => $parameterBag->get('partner_directory')
        ]);
    }
}
