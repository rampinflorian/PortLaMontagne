<?php

namespace App\Controller;

use App\Entity\ClimbingGroup;
use App\Form\ClimbingGroupType;
use App\Repository\ClimbingGroupRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/climbing/group")
 */
class ClimbingGroupController extends AbstractController
{
    /**
     * @Route("/", name="climbing_group_index", methods={"GET"})
     */
    public function index(ClimbingGroupRepository $climbingGroupRepository): Response
    {
        return $this->render('climbing_group/index.html.twig', [
            'climbing_groups' => $climbingGroupRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="climbing_group_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $climbingGroup = new ClimbingGroup();
        $form = $this->createForm(ClimbingGroupType::class, $climbingGroup);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($climbingGroup);
            $entityManager->flush();

            return $this->redirectToRoute('climbing_group_index');
        }

        return $this->render('climbing_group/new.html.twig', [
            'climbing_group' => $climbingGroup,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="climbing_group_show", methods={"GET"})
     */
    public function show(ClimbingGroup $climbingGroup): Response
    {
        return $this->render('climbing_group/show.html.twig', [
            'climbing_group' => $climbingGroup,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="climbing_group_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ClimbingGroup $climbingGroup): Response
    {
        $form = $this->createForm(ClimbingGroupType::class, $climbingGroup);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('climbing_group_index');
        }

        return $this->render('climbing_group/edit.html.twig', [
            'climbing_group' => $climbingGroup,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="climbing_group_delete", methods={"DELETE"})
     */
    public function delete(Request $request, ClimbingGroup $climbingGroup): Response
    {
        if ($this->isCsrfTokenValid('delete'.$climbingGroup->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($climbingGroup);
            $entityManager->flush();
        }

        return $this->redirectToRoute('climbing_group_index');
    }
}
