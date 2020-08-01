<?php

namespace App\Controller;

use App\Repository\TopoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShopController extends AbstractController
{
    /**
     * @Route("/shop", name="shop_index")
     * @param TopoRepository $topoRepository
     * @return Response
     */
    public function index(TopoRepository $topoRepository)
    {

        return $this->render('shop/index.html.twig', [
            'topos' => $topoRepository->findAll()
        ]);
    }
}
