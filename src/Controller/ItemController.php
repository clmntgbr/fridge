<?php

namespace App\Controller;

use App\Entity\Fridge;
use App\Entity\Item;
use App\Service\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;

class ItemController extends AbstractController
{
    #[Route('/fridge/{id}/item/{item_id}', name: 'app_item')]
    #[ParamConverter('fridge', class: Fridge::class)]
    #[ParamConverter('item', class: Item::class, options: ['id'=>'item_id'])]
    public function fridge(Fridge $fridge, Item $item, Security $security, RouterInterface $router)
    {
        if ($security->getUser()->getId() !== $fridge->getUser()->getId()) {
            return $this->redirect($router->generate('app_fridges'));
        }

        if ($security->getUser()->getId() !== $item->getFridge()->getUser()->getId()) {
            return $this->redirect($router->generate('app_fridges'));
        }

        return $this->render('item/item.html.twig', [
            'item' => $item,
        ]);
    }
}
