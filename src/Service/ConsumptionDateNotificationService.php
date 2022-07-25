<?php

namespace App\Service;

use App\Entity\Item;
use App\Repository\FridgeRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Email;

class ConsumptionDateNotificationService
{
    public function __construct(
        private MailerService $mailerService,
        private FridgeRepository $fridgeRepository,
        private string $hostname,
        private string $subject = 'Some of your products will be out of time soon !'
    ) {
    }

    /** @param Item[] $items */
    public function groupByFridge(array $items)
    {
        $data = [];

        foreach ($items as $item) {
            $data[$item->getFridge()->getId()][] = $item;
        }

        return $data;
    }

    public function send(array $items, string $key)
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
                ->htmlTemplate('Email/consumption_date_notification.html.twig')
                ->context([
                    'fridge_id' => $fridge->getId(),
                    'subject' => $this->subject,
                    'items_count' => count($items),
                    'data' => $items,
                    'hostname' => $this->hostname,
                ])
        );
    }
}