<?php

namespace App\Service;

use App\Entity\ExpirationDateNotification;
use App\Repository\FridgeRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\RouterInterface;

class ExpirationDateNotificationService
{
    public function __construct(
        private MailerService $mailerService,
        private FridgeRepository $fridgeRepository,
        private RouterInterface $router,
        private string $hostname,
        private string $subject = 'Some of your products will be out of time soon !'
    ) {
    }

    public function send(array $items, string $key, ExpirationDateNotification $expirationDateNotification)
    {
        $fridge = $this->fridgeRepository->findOneBy(['id' => $key]);
        if (null === $fridge) {
            return;
        }

        $this->mailerService->send(
            (new TemplatedEmail())
                ->from('alert@fridge.com')
                ->to($fridge->getUser()->getEmail())
                ->priority(Email::PRIORITY_HIGH)
                ->subject($this->subject)
                ->htmlTemplate('Email/expiration_date_notification.html.twig')
                ->context([
                    'fridge_id' => $fridge->getId(),
                    'subject' => $this->subject,
                    'items_count' => count($items),
                    'days_before' => $expirationDateNotification->getDaysBefore(),
                    'data' => $items,
                    'hostname' => $this->hostname,
                ])
        );
    }
}