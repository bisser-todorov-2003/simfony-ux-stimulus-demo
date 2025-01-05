<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\AddItemToCartFormType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CartController extends AbstractController
{
    #[Route('/cart', name: 'app_cart')]
    public function index(): Response
    {
        return $this->render('cart/index.html.twig', [
            'controller_name' => 'CartController',
        ]);
    }

    #[Route("/product/{id}", name: 'add_item_to_cart')]
    public function addItemToCart(int $id, EntityManagerInterface $entityManager): Response
    {
        $product = $entityManager->getRepository(Product::class)->get($id);

        $addCartForm = $this->createForm(AddItemToCartFormType::class, null, ['product' => $product]);
        return $this->render('cart/add_item.html.twig', [
            'addCartForm' => $addCartForm->createView(),
        ]);
    }

}
