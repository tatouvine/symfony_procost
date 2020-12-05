<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StoreController extends AbstractController
{
    /**
     * @Route("/store/product/{id}/details/{slug}", name="store_product", requirements={"id":"\d+"},methods={"GET"})
     */
    public function store(Request $request, int $id,string $slug): Response
    {
        $url_from_router = $this->generateUrl('store_product', [
            'id' => $id,
            'slug'=>$slug
        ]);
        return $this->render('store_product.html.twig', [
            'id'=>$id,
            'slug'=>$slug,
            'ip'=>$request->getClientIp(),
            'url_from_request'=>$request->getPathInfo(),
            'url_from_router'=>$url_from_router
        ]);
    }
}