<?php

namespace App\Controller;

use App\Entity\Comment;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends AbstractController
{
    /**
     * @Route("/comment/delete/{comment}", name="comment_delete")
     * @param Comment $comment
     * @param Request $request
     * @return Response
     */
    public function delete(Comment $comment, Request $request)
    {

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($comment);
        $entityManager->flush();

        return $this->redirect($request->headers->get('referer') ?? $this->generateUrl('article_index'));

    }
}
