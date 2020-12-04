<?php


namespace App\Service;


use App\Entity\MarketProduct;
use App\Entity\User;
use App\Security\EmailVerifier;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

class SendMailService
{
    private EmailVerifier $emailVerifier;
    private MailerInterface $mailer;
    private TemplatedEmail $email;
    protected Address $plmEmail;

    public function __construct(EmailVerifier $emailVerifier, MailerInterface $mailer)
    {
        $this->emailVerifier = $emailVerifier;
        $this->mailer = $mailer;
        $this->email = new TemplatedEmail();
        $this->plmEmail = new Address('contact@florianrampin.fr');
        $this->email->from($this->plmEmail);
    }

    /**
     * @param User $user
     */
    public function accountConfirmation(User $user): void
    {
        $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
            (new TemplatedEmail())
                ->from(new Address('contact@florianrampin.fr', 'Portlamontagne'))
                ->to($user->getEmail())
                ->subject('Confirmation de votre email')
                ->htmlTemplate('mailer/confirmation_email.html.twig')
        );
    }

    /**
     * @param User $user
     * @param MarketProduct $marketProduct
     * @throws TransportExceptionInterface
     */
    public function newMarket(User $user, MarketProduct $marketProduct): void
    {
        $this->email
            ->to($user->getEmail())
            ->subject("Ton article a été ajouté au market")
            ->htmlTemplate('mailer/market_new.html.twig')
            ->context([
                'user' => $user,
                'market_product' => $marketProduct
            ]);

        $this->mailer->send($this->email);
    }
}