<?php
declare(strict_types=1);

namespace App\Service\Notify;

use App\DTO\MessageInput;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class MailerNotify implements NotifyInterface
{
    private string $mailerFrom;
    private string $mailerTo;

    public function __construct(
        private readonly MailerInterface $mailer,
        readonly ParameterBagInterface $params,
    )
    {
        $this->mailerFrom = $params->get('mailer_from');
        $this->mailerTo = $params->get('mailer_to');
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function send(MessageInput $messageInput): void
    {
        $email = (new Email())
            ->from($this->mailerFrom)
            ->to($this->mailerTo)
            ->subject($messageInput->getTitle())
            ->text($messageInput->getContent());

        $this->mailer->send($email);
    }
}
