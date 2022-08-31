<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    // Mon panier
    #[Route('/mon-panier', name: 'app_cart')]
    public function index(Cart $cart)
    {
       $cartComplete = [];
        foreach ($cart->get() as $id => $quantity) {
            $cartComplete[] = [
                'product' => $this->entityManager->getRepository(Product::class)->findOneById($id),
                'quantity' => $quantity
            ];
       }

        // dd($cartComplete);

        return $this->render('cart/index.html.twig', [
             'cart' => $cartComplete
        ]);
    }

    // Ajout
    #[Route('/cart/add/{id}', name: 'add_to_cart')]
    public function add(Cart $cart, $id): Response
    {
        $cart->add($id);
        return $this->redirectToRoute('app_cart');
    }

   // Suppression de panier 
    #[Route('/cart/remove', name: 'remove_my_cart')]
    public function remove(Cart $cart)
    {
        // je définis remove dans l'entité Cart
        $cart->remove();

        // Il s'agit du remove de la biblihothèque SessionInterface (Removes an attribute.)
        return $this->redirectToRoute('app_products');

    }
}