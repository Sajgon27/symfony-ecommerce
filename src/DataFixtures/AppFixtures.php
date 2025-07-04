<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
            for ($i = 0; $i < 30; $i++) {
            $product = new Product();
            $product->setName('Papier toal '.$i);
            $product->setPrice(mt_rand(10, 100));
            $product->setEan(2301203);
            $product->setDescription('eoeo eoe oeo');
            $product->setStock(2);
            $product->setMainImage('/test-image');
            $product->setIsFeatured(false);
            $manager->persist($product);
        }

        $manager->flush();
    }
}
