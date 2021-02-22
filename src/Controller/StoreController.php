<?php

namespace App\Controller;

use App\Entity\Src\Store\Comment;
use App\Form\CommentType;
use App\Manager\CommentManager;
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
    private CommentManager $commentManager;

    public function __construct(ProductRepository $productRepository, BrandRepository $brandRepository, CommentManager $commentManager)
    {
        $this->productRepository = $productRepository;
        $this->brandRepository = $brandRepository;
        $this->commentManager = $commentManager;
    }

    /**
     * @Route("/store", name="store_all")
     */
    public function storeAll(): Response
    {
        $products = $this->productRepository->findAllWithImage();
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
    public function storeWithBrand(Request $request, int $brand): Response
    {
        $products = $this->productRepository->findAllWithImageById($brand);
        return $this->render('store_all_product.html.twig', [
            'products' => $products,
            'actualBrand' => $brand
        ]);
    }

    /**
     * @Route("/store/product/{id}/details/{slug}", name="store_one_product", requirements={"id":"\d+"},methods={"GET","POST"})
     * @param Request $request
     * @param int $id
     * @param string $slug
     * @return Response
     */
    public function store(Request $request, int $id, string $slug): Response
    {
        $product = $this->productRepository->findByIdAndSlug($id, $slug);
        if ($product === null) {
            throw new NotFoundHttpException();
        }

        $comment = new Comment();
        $comment->setProduct($product);
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
        $commentaires = $product->getComments()->getValues();
        if ($form->isSubmitted() && $form->isValid()) {
            $this->commentManager->save($comment);
            return $this->redirectToRoute('store_one_product',
                [
                    'id' => $id,
                    'slug' => $slug
                ]);
        }


        return $this->render('store_one_product.html.twig', [
            'product' => $product,
            'commentaires' => $commentaires,
            'form' => $form->createView()
        ]);
    }
}
