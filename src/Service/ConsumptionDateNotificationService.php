<?php

namespace App\Service;

use App\Entity\ConsumptionDate;
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

    /** @param ConsumptionDate[] $consumptionDates */
    public function groupByFridge(array $consumptionDates)
    {
        $data = [];

        foreach ($consumptionDates as $consumptionDate) {
            $data[$consumptionDate->getItem()->getFridge()->getId()][] = $consumptionDate;
        }

        return $data;
    }

    public function send(array $consumptionDates)
    {
        foreach ($consumptionDates as $key => $data) {
            $fridge = $this->fridgeRepository->findOneBy(['id' => $key]);
            if (null === $fridge) {
                continue;
            }

//            dump($data[0]->getItem()->getProduct()->getImageIngredientsName());
//            die;
            
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
                        'data' => $data,
                        'hostname' => $this->hostname,
                ])
            );
        }
    }
}