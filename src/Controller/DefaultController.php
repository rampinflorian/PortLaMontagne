<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Service\CallWeatherAPIService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/default/alerts", name="default_alerts", methods={"GET"})
     * @param ArticleRepository $articleRepository
     * @return Response
     */
    public function indexAlerts(ArticleRepository $articleRepository): Response
    {
        return $this->json([
            'code' => 200,
            'alerts' => count($articleRepository->findByActivatedAlert())
        ]);
    }

    /**
     * @Route("/default/open-weather-map", name="default_open-weather-map")
     * @param CallWeatherAPIService $callWeatherAPIService
     */
    public function openWeatherMapAction(CallWeatherAPIService $callWeatherAPIService) : Response
    {


        return $this->json([
            'code' => 200,
            'weather' => $callWeatherAPIService->findByCity('TOULON')
        ]);
    }
}
