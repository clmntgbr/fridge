<?php

namespace App\Admin\Controller;

use App\Entity\Fridge;
use App\Form\ItemType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class FridgeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Fridge::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            FormField::addPanel('Fridge Details'),
            IdField::new('id')->setDisabled(),
            NumberField::new('itemsCount')->hideOnForm(),
            TextField::new('name'),
            AssociationField::new('user')->setDisabled(),
            CollectionField::new('items')
                ->setEntryIsComplex()
                ->setEntryType(ItemType::class)
                ->hideOnIndex()
        ];
    }
}
