<?php

namespace App\Controller;

use App\Repository\Src\Store\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StoreController extends AbstractController
{
    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * @Route("/store", name="store_all")
     */
    public function storeAll(): Response
    {
        $products = $this->productRepository->findAll();
        return $this->render('store_all_product.html.twig', [
            'products' => $products,
        ]);
    }

    /**
     * @Route("/store/{brand}", name="store_with_brand")
     * @param Request $request
     * @param int $brand
     * @return Response
     */
    public function storeWithBrand(Request $request,int $brand): Response
    {
        $products = $this->productRepository->findBy(['brand'=>$brand]);
        return $this->render('store_all_product.html.twig', [
            'products' => $products,
        ]);
    }

    /**
     * @Route("/store/product/{id}/details/{slug}", name="store_one_product", requirements={"id":"\d+"},methods={"GET"})
     */
    public function store(Request $request, int $id, string $slug): Response
    {
        $product = $this->productRepository->find($id);
        return $this->render('store_one_product.html.twig', [
            'product' => $product
        ]);
    }
}