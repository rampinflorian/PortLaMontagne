<?php

namespace App\Controller;

use App\Entity\Newsletter;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NewsletterController extends AbstractController
{
    /**
     * @Route("/newsletter/add", name="newsletter_add")
     * @return Response
     */
    public function add(): Response
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

            $this->addFlash('success', "Vous avez été ajouté à la Newsletter !");
            return $this->redirectToRoute('article_index');
        } else {
            $this->addFlash('error', "Vous devez vous connecter !");
            return $this->redirectToRoute('article_index');
        }
    }

    /**
     * @Route("/newsletter/remove", name="newsletter_remove")
     */
    public function removeAction() : Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $this->getUser()->getNewsletter()->setIsActivated(false);
        $entityManager->flush();

        return $this->redirectToRoute('article_index');

    }
}
