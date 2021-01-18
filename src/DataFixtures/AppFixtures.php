<?php

namespace App\DataFixtures;

use App\Entity\Src\Store\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    private $manager;

    public function load(ObjectManager $manager): void
    {
        $this->manager = $manager;
        $this->loadProducts();
        $this->manager->flush();

        $manager->flush();
    }

    private function loadProducts(): void
    {
        for ($i = 0; $i < 20; $i++) {
            $product = (new Product())
                ->setName('product ' . $i)
                ->setDescription('Produit de description ' . $i)
                ->setPrice(mt_rand(10, 100));

            $this->manager->persist($product);
        }
    }
}
