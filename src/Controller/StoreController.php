<?php

namespace App\Controller;

use App\Repository\Src\Store\BrandRepository;
use App\Repository\Src\Store\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class StoreController extends AbstractController
{
    private ProductRepository $productRepository;
    private BrandRepository $brandRepository;

    public function __construct(ProductRepository $productRepository, BrandRepository $brandRepository)
    {
        $this->productRepository = $productRepository;
        $this->brandRepository = $brandRepository;
    }

    /**
     * @Route("/store", name="store_all")
     */
    public function storeAll(): Response
    {
        $products = $this->productRepository->findAll();
        $brands = $this->brandRepository->findAll();
        return $this->render('store_all_product.html.twig', [
            'products' => $products,
            'brands' => $brands
        ]);
    }

    /**
     * @Route("/store/{brand}", name="store_with_brand")
     * @param Request $request
     * @param int $brand
     * @return Response
     */
    public function storeWithBrand(Request $request, int $brand): Response
    {
        $products = $this->productRepository->findBy(['brand' => $brand]);
        $brands = $this->brandRepository->findAll();
        $actualyBrand= ($this->brandRepository->find($brand))->getName();
        return $this->render('store_all_product.html.twig', [
            'products' => $products,
            'brands' => $brands,
            'actualyBrand'=>$actualyBrand
        ]);
    }

    /**
     * @Route("/store/product/{id}/details/{slug}", name="store_one_product", requirements={"id":"\d+"},methods={"GET"})
     */
    public function store(Request $request, int $id, string $slug): Response
    {
        $product = $this->productRepository->find($id);
        if ($product === null) {
            throw new NotFoundHttpException();
        }
        if ($product->getSlug() !== $slug) {
            return $this->redirectToRoute('store_show_product', [
                'id' => $id,
                'slug' => $product->getSlug(),
            ], HTTP_MOVED_PERMANENTLY);
        }
        $brands = $this->brandRepository->findAll();
        $actualyBrand = $product->getBrand()->getName();
        return $this->render('store_one_product.html.twig', [
            'product' => $product,
            'brands' => $brands,
            'actualyBrand' =>$actualyBrand
        ]);
    }
}