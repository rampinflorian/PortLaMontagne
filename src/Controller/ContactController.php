<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     * @param Request $request
     * @param MailerInterface $mailer
     * @return Response
     * @throws TransportExceptionInterface
     */
    public function index(Request $request, MailerInterface $mailer)
    {
        $data = [];
        $form = $this->createForm(ContactType::class, $data);
        $form->handleRequest($request);

        if ($this->getUser()) {
            /* @var User $user*/
            $user = $this->getUser();
            $form->get('fullName')->setData($user->getFullName());
            $form->get('email')->setData($user->getEmail());
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $email = (new Email())
                ->from('florian@portlamontagne.fr')
                ->to('florian@portlamontagne.fr')
                ->subject('[PortLaMontagne.fr] Nouveau mail de contact')
                ->text('
                Expéditeur : ' . $form['fullName']->getData() . '
                Email : ' . $form['email']->getData() . '
                Sujet : ' . $form['subject']->getData() . '
                Message : ' . $form['message']->getData() . '
                ');

            $mailer->send($email);
            $this->addFlash('success', 'Votre message a été envoyé, une réponse vous sera apportée au plus vite !');
            $this->redirectToRoute('home');
        }

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
