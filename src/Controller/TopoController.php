<?php

namespace App\Controller;

use App\Repository\TopoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TopoController extends AbstractController
{
    /**
     * @Route("/topo", name="topo_index")
     * @param TopoRepository $topoRepository
     * @return Response
     */
    public function index(TopoRepository $topoRepository)
    {

        return $this->render('topo/index.html.twig', [
            'topos' => $topoRepository->findAll()
        ]);
    }
}
