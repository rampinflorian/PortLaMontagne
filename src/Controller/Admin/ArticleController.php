<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use App\Service\FileService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("admin/article")
 */
class ArticleController extends AbstractController
{
    /**
     * @Route("/", name="admin_article_index", methods={"GET"})
     * @param ArticleRepository $articleRepository
     * @return Response
     */
    public function index(ArticleRepository $articleRepository): Response
    {
        return $this->render('article/index_admin.html.twig', [
            'articles' => $articleRepository->findAllByOrder('DESC'),
        ]);
    }

    /**
     * @Route("/new", name="admin_article_new", methods={"GET","POST"})
     * @param Request $request
     * @param FileService $fileService
     * @return Response
     */
    public function new(Request $request, FileService $fileService): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $article->setUser($this->getUser());

            $image = $form->get('image')->getData();
            $newFilename = $fileService->getFileName($image);

            $image->move($this->getParameter('article_directory') . '/image/', $newFilename);

            $article->setImage($newFilename);

            if (!$form->get('isAlert')->getData()) {
                $article->setAlert(null);
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('article_index');
        }

        return $this->render('article/new.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{slug}/edit", name="admin_article_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Article $article
     * @param FileService $fileService
     * @return Response
     */
    public function edit(Request $request, Article $article, FileService $fileService): Response
    {
        $orphanImage = $article->getImage();
        $article->setImage(
            new File($this->getParameter('article_directory') . '/image/' . $article->getImage())
        );

        $form = $this->createForm(ArticleType::class, $article, [
            'required_header_image' => false
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!$form->get('isAlert')->getData()) {
                $article->setAlert(null);
            }
            if ($article->getImage() !== $orphanImage && $form->get('image')->getData() != null) {
                $newImage = $form->get('image')->getData();
                $newFilename = $fileService->getFileName($newImage);
                $newImage->move($this->getParameter('article_directory') . '/image/', $newFilename);
                $fileService->deleteFile($this->getParameter('article_directory') . '/image/' . $orphanImage);
                $article->setImage($newFilename);
            } else {
                $article->setImage($orphanImage);
            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('article_index');
        }

        return $this->render('article/edit.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/{slug}", name="admin_article_delete", methods={"DELETE"})
     * @param Request $request
     * @param Article $article
     * @return Response
     */
    public function delete(Request $request, Article $article): Response
    {
        if ($this->isCsrfTokenValid('delete' . $article->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($article);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_article_index');
    }

    /**
     * @Route("/uploadimage", name="admin_article_uploadimage", methods={"POST"})
     * @param Request $request
     */
    public function uploadImage(Request $request)
    {
        /** @var UploadedFile $file */
        $file = $request->files->get('image');
        $status = [
            'status' => "error",
            "fileUploaded" => false,
        ];
        if (!is_null($file)) {
            $filename = 'articleImageContent_' . uniqid() . "." . $file->getClientOriginalExtension();
            $path = $this->getParameter('article_directory') . '/content/';
            $file->move($path, $filename);

            $status = [
                'status' => "success",
                "fileUploaded" => true,
                "filename" => $filename,
            ];
        }

        return $this->json($status, 200);
    }
}
