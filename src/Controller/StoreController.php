<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StoreController extends AbstractController
{
    /**
     * @Route("/store", name="store_all")
     */
    public function storeAll(): Response
    {
        return $this->render('store_all_product.html.twig');
    }

    /**
     * @Route("/store/product/{id}/details/{slug}", name="store_one_product", requirements={"id":"\d+"},methods={"GET"})
     */
    public function store(Request $request, int $id,string $slug): Response
    {
        return $this->render('store_one_product.html.twig', [
            'id'=>$id,
            'slug'=>$slug,
        ]);
    }
}