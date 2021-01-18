<?php

namespace App\Manager;

use App\Entity\Src\Store\Product;
use App\Repository\Src\Store\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;

class ProjectManager
{

    private EntityManagerInterface $em;
    private ProductRepository $productRepository;

    public function __construct(EntityManagerInterface $em, ProductRepository $productRepository)
    {
        $this->em = $em;
        $this->productRepository = $productRepository;
    }

    public function addNewProduct(string $name, string $description, string $price)
    {
        $product = (new Product())
            ->setName($name)
            ->setDescription($description)
            ->setPrice($price);

        $this->em->persist($product);

        $this->em->flush();
    }

    public function editProduct(string $id, string $edit, string $fieldsEdit)
    {
        $product = $this->productRepository->find($id);
        switch (true)
        {
            case $fieldsEdit === "name":
                {
                    $product->setName($edit);
                }
                break;

            case $fieldsEdit === "description":
                {
                    $product->setDescription($edit);
                }
                break;

            case $fieldsEdit === "price":
                {
                    $product->setPrice($edit);
                }
                break;

            default:
            {
                throw  new \ErrorException();
            }

        }
        $this->em->flush();
    }

    public function deletOneProduct(string $id)
    {
        $product = $this->productRepository->find($id);
        $this->em->remove($product);
        $this->em->flush();
    }


}