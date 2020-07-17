<?php

namespace App\Controller;

use App\Entity\Newsletter;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NewsletterController extends AbstractController
{
    /**
     * @Route("/newsletter/add", name="newsletter_add")
     * @param Request $request
     * @return Response
     */
    public function add(Request $request): Response
    {
        if ($this->getUser()) {

            if ($this->getUser()->getNewsletter()) {
                $this->getUser()->getNewsletter()->setIsActivated(true);
            } else {
                $newsLetter = (new Newsletter())
                    ->setUser($this->getUser())
                    ->setIsActivated(true);
                $this->getDoctrine()->getManager()->persist($newsLetter);
            }

            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', "Newsletter;Tu es inscris à la Newsletter !");
            return $this->redirect($request->headers->get('referer') ?? $this->generateUrl('article_index'));
        } else {
            $this->addFlash('error', "Newsletter;Oops! Tu dois être connecté");
            return $this->redirect($request->headers->get('referer') ?? $this->generateUrl('article_index'));
        }
    }

    /**
     * @Route("/newsletter/remove", name="newsletter_remove")
     * @param Request $request
     * @return Response
     */
    public function removeAction(Request $request) : Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $this->getUser()->getNewsletter()->setIsActivated(false);
        $entityManager->flush();

        $this->addFlash('success', "Newsletter;Tu n'es plus inscris à la Newsletter");

        return $this->redirect($request->headers->get('referer') ?? $this->generateUrl('article_index'));
    }
}
