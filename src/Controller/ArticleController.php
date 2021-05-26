<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use App\Entity\User;
use App\Form\ArticleType;
use App\Form\CommentType;
use App\Repository\ArticleRepository;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/article")
 */
class ArticleController extends AbstractController
{
    /**
     * @Route("/", name="article_index", methods={"GET"})
     * @param ArticleRepository $articleRepository
     * @return Response
     */
    public function index(ArticleRepository $articleRepository): Response
    {
        return $this->render('article/index.html.twig', [
            'articles' => $articleRepository->findAllActive(),
        ]);
    }
    /**
     * @Route("/alerts", name="article_alert_index", methods={"GET"})
     * @param ArticleRepository $articleRepository
     * @return Response
     */
    public function indexAlerts(ArticleRepository $articleRepository): Response
    {
        return $this->render('article/index.html.twig', [
            'articles' => $articleRepository->findByActivatedAlert()
        ]);
    }

    /**
     * @Route("/{slug}", name="article_show", methods={"GET","POST"})
     * @param Article $article
     * @param ArticleRepository $articleRepository
     * @param CommentRepository $commentRepository
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function show(
        Article $article,
        ArticleRepository $articleRepository,
        CommentRepository $commentRepository,
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
        $alreadyCommented = false;
        foreach ($article->getComments() as $comment) {
            /* @var Comment $comment */
            $alreadyCommented = ($comment->getUser() == $this->getUser()) ? true : $alreadyCommented;
        }


        $comment = new Comment();
        /* @var User $user */
        $user = $this->getUser();

        $formComment = $this->createForm(CommentType::class, $comment);

        $formComment->handleRequest($request);
        if ($formComment->isSubmitted() && $formComment->isValid()) {
            $comment->setUser($user);
            $comment->setArticle($article);

            $entityManager->persist($comment);
            $entityManager->flush();

            $this->addFlash('success', 'Commentaire;Ton commentaire a été ajouté !');

            return $this->redirect($request->headers->get('referer') ?? $this->generateUrl('article_index'));
        }

        return $this->render('article/show.html.twig', [
            'article' => $article,
            'articles' =>  $articleRepository->FindLastActiveWithMaxResultWithoutOne(3, $article),
            'comments' => $commentRepository->findByArticle($article),
            'formComment' => $formComment->createView(),
            'alreadyComment' => $alreadyCommented
        ]);
    }
}
