<?php

namespace App\Admin\Controller;

use App\Entity\User;
use App\Form\ExpirationDateNotificationType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->setDisabled(),
            TextField::new('email'),
            Field::new('isEnable'),
            CollectionField::new('expirationDateNotifications')
                ->hideOnIndex()
                ->setEntryIsComplex()
                ->setEntryType(ExpirationDateNotificationType::class)
        ];
    }
}
