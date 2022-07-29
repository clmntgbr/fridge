<?php

namespace App\Admin\Controller;

use App\Entity\ExpirationDateNotification;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;

class ExpirationDateNotificationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ExpirationDateNotification::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->setDisabled(),
            NumberField::new('daysBefore'),
            AssociationField::new('user'),
        ];
    }
}
