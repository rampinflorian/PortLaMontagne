<?php


namespace App\Service;


use App\Entity\User;
use App\Security\EmailVerifier;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Address;

class SendMailService
{
    private EmailVerifier $emailVerifier;

    public function __construct(EmailVerifier $emailVerifier)
    {
        $this->emailVerifier = $emailVerifier;
    }

    public function sendEmailConfirmation(User $user) : void
    {
        $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
            (new TemplatedEmail())
                ->from(new Address('florian@portlamontagne.fr', 'Portlamontagne'))
                ->to($user->getEmail())
                ->subject('Confirmation de votre email')
                ->htmlTemplate('registration/confirmation_email.html.twig')
        );
    }
}