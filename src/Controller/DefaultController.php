<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Service\CallWeatherAPIService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use  Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

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
     * @return Response
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function openWeatherMapAction(CallWeatherAPIService $callWeatherAPIService): Response
    {
        return $this->json([
            'code' => 200,
            'weather' => $callWeatherAPIService->findByCity('TOULON')
        ]);
    }
}
