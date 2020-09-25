<?php

namespace App\Controller\User;

use App\Repository\CommentRepository;
use App\Repository\MarketProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MarketProductController extends AbstractController
{
    /**
     * @Route("/user/market-products", name="user_marketproducts")
     * @param MarketProductRepository $marketProductRepository
     * @return Response
     */
    public function index(MarketProductRepository $marketProductRepository)
    {

        return $this->render('user/market/index.html.twig', [
            'marketproducts' => $marketProductRepository->findByVendor($this->getUser())
        ]);
    }
}
