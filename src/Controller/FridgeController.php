<?php

namespace App\Controller;

use App\Entity\Fridge;
use App\Service\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;

class FridgeController extends AbstractController
{
    #[Route('/fridges', name: 'app_fridges')]
    public function index(): Response
    {
        return $this->render('fridge/index.html.twig', []);
    }

    #[Route('/fridge/{id}', name: 'app_fridge')]
    #[ParamConverter('fridge', class: Fridge::class)]
    public function fridge(Fridge $fridge, Security $security, RouterInterface $router)
    {
        if ($security->getUser()?->getId() !== $fridge->getUser()->getId()) {
            return $this->redirect($router->generate('app_fridges'));
        }

        return $this->render('fridge/fridge.html.twig', [
            'fridge' => $fridge,
        ]);
    }
}
