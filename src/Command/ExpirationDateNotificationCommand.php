<?php

namespace App\Command;

use App\Repository\ExpirationDateNotificationRepository;
use App\Repository\ItemRepository;
use App\Service\ExpirationDateNotificationService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'expiration_date_notification',
    description: 'Once a day',
)]
class ExpirationDateNotificationCommand extends Command
{
    public function __construct(
        private ExpirationDateNotificationRepository $expirationDateNotificationRepository,
        private ItemRepository $itemRepository,
        private ExpirationDateNotificationService $expirationDateNotificationService,
        string                        $name = null
    )
    {
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this->setDescription(self::getDescription());
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $expirationDateNotifications = $this->expirationDateNotificationRepository->findAll();

        foreach ($expirationDateNotifications as $expirationDateNotification) {
            foreach ($expirationDateNotification->getUser()->getFridges() as $fridge) {
                $items = $this->itemRepository->findItemsByDaysBefore($expirationDateNotification, $fridge);
                if (count($items) === 0) {
                    continue;
                }
                $this->expirationDateNotificationService->send($items, $fridge->getId(), $expirationDateNotification);
            }
        }

        return Command::SUCCESS;
    }
}
