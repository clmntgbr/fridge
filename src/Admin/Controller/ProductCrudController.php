<?php

namespace App\Admin\Controller;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $imagesDirectory = '/images/products/';

        return [
            FormField::addPanel('Product Details'),
            IdField::new('id')->setDisabled(true),
            TextField::new('ean'),
            TextField::new('name'),
            TextField::new('brand'),
            AssociationField::new('productStatus'),
            TextField::new('imagesDirectory'),

            FormField::addPanel('Nutritions Details'),
            TextField::new('nutrition.country')->hideOnIndex(),
            TextField::new('nutrition.categories')->hideOnIndex(),
            TextField::new('nutrition.ecoscore_grade')->hideOnIndex(),
            TextField::new('nutrition.ecoscore_score')->hideOnIndex(),
            TextField::new('nutrition.nutriscore_grade')->hideOnIndex(),
            TextField::new('nutrition.nutriscore_score')->hideOnIndex(),
            TextField::new('nutrition.quantity')->hideOnIndex(),
            TextField::new('nutrition.ingredients_text')->hideOnIndex(),

            FormField::addPanel('Image'),
            TextField::new('imageFile', 'Upload')
                ->setFormType(VichImageType::class)
                ->onlyOnForms(),
            ImageField::new('image.name', 'Image')
                ->setRequired(true)
                ->setBasePath($imagesDirectory)
                ->hideOnForm(),
            TextField::new('image.name', 'Name')->setDisabled()->hideOnIndex(),
            TextField::new('image.originalName', 'originalName')->setDisabled()->hideOnIndex(),
            NumberField::new('image.size', 'Size')->setDisabled()->hideOnIndex(),
            TextField::new('image.mimeType', 'mimeType')->setDisabled()->hideOnIndex(),
            ArrayField::new('image.dimensions', 'Dimensions')->setDisabled()->hideOnIndex(),

            FormField::addPanel('Image Ingredients'),
            TextField::new('imageIngredientsFile', 'Upload')
                ->setFormType(VichImageType::class)
                ->onlyOnForms(),
            ImageField::new('imageIngredients.name', 'Image Ingredients')
                ->setRequired(true)
                ->setBasePath($imagesDirectory)
                ->hideOnForm(),
            TextField::new('imageIngredients.name', 'Name')->setDisabled()->hideOnIndex(),
            TextField::new('imageIngredients.originalName', 'originalName')->setDisabled()->hideOnIndex(),
            NumberField::new('imageIngredients.size', 'Size')->setDisabled()->hideOnIndex(),
            TextField::new('imageIngredients.mimeType', 'mimeType')->setDisabled()->hideOnIndex(),
            ArrayField::new('imageIngredients.dimensions', 'Dimensions')->setDisabled()->hideOnIndex(),

            FormField::addPanel('Image Nutrition'),
            TextField::new('imageNutritionFile', 'Upload')
                ->setFormType(VichImageType::class)
                ->onlyOnForms(),
            ImageField::new('imageNutrition.name', 'Image Nutrition')
                ->setRequired(true)
                ->setBasePath($imagesDirectory)
                ->hideOnForm(),
            TextField::new('imageNutrition.name', 'Name')->setDisabled()->hideOnIndex(),
            TextField::new('imageNutrition.originalName', 'originalName')->setDisabled()->hideOnIndex(),
            NumberField::new('imageNutrition.size', 'Size')->setDisabled()->hideOnIndex(),
            TextField::new('imageNutrition.mimeType', 'mimeType')->setDisabled()->hideOnIndex(),
            ArrayField::new('imageNutrition.dimensions', 'Dimensions')->setDisabled()->hideOnIndex(),
        ];
    }
}
