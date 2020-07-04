<?php

namespace App\Controller\Admin;

use App\Entity\Partner;
use App\Form\PartnerType;
use App\Repository\PartnerRepository;
use App\Service\FileService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("admin/partner")
 */
class PartnerController extends AbstractController
{
    /**
     * @Route("/", name="partner_index", methods={"GET"})
     * @param PartnerRepository $partnerRepository
     * @return Response
     */
    public function index(PartnerRepository $partnerRepository): Response
    {
        return $this->render('partner/index.html.twig', [
            'partners' => $partnerRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="partner_new", methods={"GET","POST"})
     * @param Request $request
     * @param FileService $fileService
     * @param ParameterBagInterface $parameterBag
     * @return Response
     */
    public function new(Request $request, FileService $fileService, ParameterBagInterface $parameterBag): Response
    {
        $partner = new Partner();
        $form = $this->createForm(PartnerType::class, $partner);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $image = $form->get('image')->getData();
            $newFilename = $fileService->getFileName($image);

            $image->move($parameterBag->get('partner_directory') . '/image/', $newFilename);
            $partner->setImage($newFilename);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($partner);
            $entityManager->flush();

            return $this->redirectToRoute('partner_index');
        }

        return $this->render('partner/new.html.twig', [
            'partner' => $partner,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="partner_show", methods={"GET"})
     * @param Partner $partner
     * @return Response
     */
    public function show(Partner $partner): Response
    {
        return $this->render('partner/show.html.twig', [
            'partner' => $partner,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="partner_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Partner $partner
     * @param FileService $fileService
     * @param ParameterBagInterface $parameterBag
     * @return Response
     */
    public function edit(Request $request, Partner $partner, FileService $fileService, ParameterBagInterface $parameterBag): Response
    {
        $form = $this->createForm(PartnerType::class, $partner);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $image = $form->get('image')->getData();
            $newFilename = $fileService->getFileName($image);

            $image->move($parameterBag->get('partner_directory') . '/image/', $newFilename);
            $partner->setImage($newFilename);

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('partner_index');
        }

        return $this->render('partner/edit.html.twig', [
            'partner' => $partner,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="partner_delete", methods={"DELETE"})
     * @param Request $request
     * @param Partner $partner
     * @return Response
     */
    public function delete(Request $request, Partner $partner): Response
    {
        if ($this->isCsrfTokenValid('delete'.$partner->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($partner);
            $entityManager->flush();
        }

        return $this->redirectToRoute('partner_index');
    }
}
