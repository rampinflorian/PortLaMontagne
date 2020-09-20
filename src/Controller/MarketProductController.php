<?php

namespace App\Controller;

use App\Entity\MarketProduct;
use App\Entity\User;
use App\Form\ContactType;
use App\Form\MarketProductType;
use App\Repository\MarketProductRepository;
use App\Service\FileService;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
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
            'market_products' => $marketProductRepository->findBy([], ['createdAt' => 'DESC']),
        ]);
    }

    /**
     * @Route("/new", name="market_product_new", methods={"GET","POST"})
     * @param Request $request
     * @param FileService $fileService
     * @return Response
     */
    public function new(Request $request, FileService $fileService): Response
    {
        $marketProduct = new MarketProduct();
        $form = $this->createForm(MarketProductType::class, $marketProduct);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /* @var User $user */
            $user = $this->getUser();

            $entityManager = $this->getDoctrine()->getManager();

            $image = $form->get('imageFirst')->getData();
            $newFilename = $fileService->getFileName($image);
            $marketProduct->setImageFirst($newFilename);
            $image->move($this->getParameter('market_directory') . '/image/', $newFilename);

            $image = $form->get('imageSecond')->getData();
            $newFilename = $fileService->getFileName($image);
            $marketProduct->setImageSecond($newFilename);
            $image->move($this->getParameter('market_directory') . '/image/', $newFilename);

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
     * @Route("/{slug}", name="market_product_show", methods={"GET", "POST"})
     * @param MarketProduct $marketProduct
     * @param Request $request
     * @param MailerInterface $mailer
     * @return Response
     * @throws TransportExceptionInterface
     */
    public function show(MarketProduct $marketProduct, Request $request, MailerInterface $mailer): Response
    {
        $data = [];
        $form = $this->createForm(ContactType::class, $data);

        if ($this->getUser()) {
            /* @var User $user */
            $user = $this->getUser();
            $form->get('fullName')->setData($user->getFirstname());
            $form->get('email')->setData($user->getEmail());
        }

        $form->get('subject')->setData($marketProduct->getTitle());
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $email = (new Email())
                ->from('florian@portlamontagne.fr')
                ->to($marketProduct->getVendor()->getEmail())
                ->subject("[PortLaMontagne.fr - Market] {$form['fullName']->getData()} s'intéresse à ton produit {$marketProduct->getTitle()} !")
                ->text("
                Expéditeur : {$form['fullName']->getData()}
                Email : {$form['email']->getData()}
                Objet du market : {$form['subject']->getData()}
                Message du potentiel acheteur : {$form['message']->getData()}
                ");

            $mailer->send($email);
            $this->addFlash('success', 'Contact;Ton message a été envoyé au vendeur !');
            return $this->redirectToRoute('market_product_index');
        }


        return $this->render('market_product/show.html.twig', [
            'market_product' => $marketProduct,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/{slug}/edit", name="market_product_edit", methods={"GET","POST"})
     * @Security("user.getId() == marketProduct.getVendor().getId()")
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
        if ($this->isCsrfTokenValid('delete' . $marketProduct->getId(), $request->request->get('_token'))) {
            if (!$marketProduct->getIsSold()) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($marketProduct);
                $entityManager->flush();
                $this->addFlash('success', 'Suppression de l\'article;Suppression effectuée !');
            } else {
                $this->addFlash('warning', 'Suppression impossible sur un produit vendu');
            }
        }

        return $this->redirectToRoute('market_product_index');
    }

    /**
     * @Route("/{slug}/sold", name="market_product_sold")
     * @param MarketProduct $marketProduct
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function sold(MarketProduct $marketProduct, EntityManagerInterface $entityManager): Response
    {
        $marketProduct->setIsSold(true);
        $marketProduct->setSoldedAt(new DateTime());
        $entityManager->flush();

        $this->addFlash('success', 'Market; Ton produit a été vendu');
        return $this->redirectToRoute('market_product_index');
    }
}
