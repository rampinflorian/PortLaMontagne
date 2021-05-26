<?php

namespace App\Controller\User;

use App\Entity\User;
use App\Form\ProfileImageType;
use App\Form\UserType;
use App\Service\FileService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class PersonalInformationController extends AbstractController
{
    /**
     * @Route("user/personal-information", name="user_personal_information")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param FileService $fileService
     * @return RedirectResponse|Response
     */
    public function index(Request $request, UserPasswordEncoderInterface $passwordEncoder, FileService $fileService)
    {
        $user = $this->getUser();
        $profileImage = null;

        $formPersonalInformation = $this->createForm(UserType::class, $user)->handleRequest($request);

        if ($formPersonalInformation->isSubmitted() && $formPersonalInformation->isValid()) {
            if ($formPersonalInformation->get('password')->getData()) {
                $user->setPassword(
                    $passwordEncoder->encodePassword(
                        $user,
                        $formPersonalInformation->get('password')->getData()
                    )
                );
            }

            $image = $formPersonalInformation->get('image')->getData();

            if ($image) {
                $newFilename = $fileService->getFileName($image);
                $image->move($this->getParameter('user_directory') . '/image/', $newFilename);
                $user->setImage($newFilename);
            }


            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'Utilisateur; Ta fiche utilisateur a été mise à jour');

            return $this->redirectToRoute('user_dashboard', []);
        }

        return $this->render('user/personal_information/index.html.twig', [
            'formUser' => $formPersonalInformation->createView(),
        ]);
    }
}
