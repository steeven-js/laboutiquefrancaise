<?php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager) //injection indépendance
    {

        //récupère données dans base de données 
        $this->entityManager = $entityManager;
    }


    #[Route('/nos-produits', name: 'app_products')]
    public function index(): Response
    {
        //Je récupère tout les produits dans la base de donné à l'aide de Doctrine qui va se charger de récupéré mon repository (doctrine)

        $products = $this->entityManager->getRepository(Product::class)->findAll();


        return $this->render('product/index.html.twig', [
            'products'=>$products,
        ]);
    }
}