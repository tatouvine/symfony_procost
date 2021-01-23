<?php

namespace App\DataFixtures;

use App\Entity\Src\Store\Brand;
use App\Entity\Src\Store\Image;
use App\Entity\Src\Store\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    private $manager;

    public function load(ObjectManager $manager): void
    {
        $this->manager = $manager;
        $this->loadBrands();
        $this->loadProducts();
        $this->manager->flush();

        $manager->flush();
    }

    private function loadBrands(): void
    {
        $brands = [
            ["Adidas"],
            ["Asics"],
            ["Nike"],
            ["Puma"],
        ];

        foreach ($brands as $key => [$name]) {
            $brand = (new Brand())->setName((string)$name);
            $this->manager->persist($brand);
            $this->addReference(Brand::class . $key, $brand);
        }
    }

    private function loadProducts(): void
    {
        for ($i = 1; $i < 15; $i++) {
            $product = (new Product())
                ->setId($i)
                ->setName('product ' . $i)
                ->setDescription("shot description du produit et c cool")
                ->setDescriptionLong('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed
                 do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                  quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis
                   aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
                    Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit
                     anim id est laborum.Produit de description ' . $i)
                ->setPrice(mt_rand(10, 100))
                ->setSlug("balbalblablalablalablablabla");

            $this->manager->persist($product);

            $image = (new Image())
                ->setUrl(sprintf('img/products/shoe-%d.jpg', $i))
                ->setAlt($product->getName());
            $product->setImage($image);

            $brand = $this->getReference(Brand::class . random_int(1, 3));
            $product->setBrand($brand);

            $this->manager->persist($product);
        }
    }
}
