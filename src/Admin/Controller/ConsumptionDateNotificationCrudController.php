<?php

namespace App\Admin\Controller;

use App\Entity\ConsumptionDateNotification;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;

class ConsumptionDateNotificationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ConsumptionDateNotification::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->setDisabled(),
            NumberField::new('daysBefore'),
            AssociationField::new('user')->setDisabled(),
        ];
    }
}
