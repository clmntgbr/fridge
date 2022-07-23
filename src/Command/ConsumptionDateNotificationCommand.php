<?php

namespace App\Command;

use App\Repository\ConsumptionDateNotificationRepository;
use App\Repository\ConsumptionDateRepository;
use App\Repository\ItemRepository;
use App\Service\ConsumptionDateNotificationService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'consumption_date_notification',
    description: 'Once a day',
)]
class ConsumptionDateNotificationCommand extends Command
{
    public function __construct(
        private ConsumptionDateNotificationRepository $consumptionDateNotificationRepository,
        private ItemRepository $itemRepository,
        private ConsumptionDateNotificationService $consumptionDateNotificationService,
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
        $consumptionDateNotifications = $this->consumptionDateNotificationRepository->findAll();

        foreach ($consumptionDateNotifications as $consumptionDateNotification) {
            $items = $this->itemRepository->findConsumptionDateByDaysBefore($consumptionDateNotification->getDaysBefore());
            $data = $this->consumptionDateNotificationService->groupByFridge($items);
            $this->consumptionDateNotificationService->send($data);
        }

        return Command::SUCCESS;
    }
}
