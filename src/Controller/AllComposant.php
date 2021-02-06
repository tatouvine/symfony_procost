<?php

namespace App\Controller;

use App\Repository\Src\Store\BrandRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class AllComposant extends AbstractController
{
    private BrandRepository $brandRepository;

    public function __construct(BrandRepository $brandRepository)
    {
        $this->brandRepository = $brandRepository;
    }

    public function composantBrand(int $brand): Response
    {
        $actualBrand = null;
        $brands = $this->brandRepository->findAll();
        if ($brand !== -1) {
            $actualBrand = ($this->brandRepository->find($brand))->getName();
        }
        return $this->render('composant_brand.html.twig', [
            'brands' => $brands,
            'actualBrand' => $actualBrand
        ]);
    }
}
