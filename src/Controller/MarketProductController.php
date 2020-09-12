<?php

namespace App\Controller;

use App\Entity\MarketProduct;
use App\Entity\User;
use App\Form\MarketProductType;
use App\Repository\MarketProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/market")
 */
class MarketProductController extends AbstractController
{
    /**
     * @Route("/", name="market_product_index", methods={"GET"})
     * @param MarketProductRepository $marketProductRepository
     * @return Response
     */
    public function index(MarketProductRepository $marketProductRepository): Response
    {
        return $this->render('market_product/index.html.twig', [
            'market_products' => $marketProductRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="market_product_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $marketProduct = new MarketProduct();
        $form = $this->createForm(MarketProductType::class, $marketProduct);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /* @var User $user */
            $user = $this->getUser();

            $entityManager = $this->getDoctrine()->getManager();

            $marketProduct->setVendor($user);
            $marketProduct->setIsSuspended(false);
            $marketProduct->setIsSold(false);

            $entityManager->persist($marketProduct);
            $entityManager->flush();

            $this->addFlash('success', 'Market; Ton produit a été ajouté');
            return $this->redirectToRoute('market_product_index');
        }

        return $this->render('market_product/new.html.twig', [
            'market_product' => $marketProduct,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{slug}", name="market_product_show", methods={"GET"})
     * @param MarketProduct $marketProduct
     * @return Response
     */
    public function show(MarketProduct $marketProduct): Response
    {
        return $this->render('market_product/show.html.twig', [
            'market_product' => $marketProduct,
        ]);
    }

    /**
     * @Route("/{slug}/edit", name="market_product_edit", methods={"GET","POST"})
     * @param Request $request
     * @param MarketProduct $marketProduct
     * @return Response
     */
    public function edit(Request $request, MarketProduct $marketProduct): Response
    {
        $form = $this->createForm(MarketProductType::class, $marketProduct);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('market_product_index');
        }

        return $this->render('market_product/edit.html.twig', [
            'market_product' => $marketProduct,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="market_product_delete", methods={"DELETE"})
     * @param Request $request
     * @param MarketProduct $marketProduct
     * @return Response
     */
    public function delete(Request $request, MarketProduct $marketProduct): Response
    {
        if ($this->isCsrfTokenValid('delete'.$marketProduct->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($marketProduct);
            $entityManager->flush();
        }

        return $this->redirectToRoute('market_product_index');
    }

    /**
     * @Route("/{slug}/sold", name="market_product_sold")
     * @param MarketProduct $marketProduct
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function sold(MarketProduct $marketProduct, EntityManagerInterface $entityManager) : Response
    {
        $marketProduct->setIsSold(true);
        $entityManager->flush();

        $this->addFlash('success', 'Market; Ton produit a été vendu');
        return $this->redirectToRoute('market_product_index');
    }
}
