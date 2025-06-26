<?php

namespace App\Service;

use App\Entity\Product;
use App\Form\ProductType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Serializer\SerializerInterface;

class ProductService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private FormFactoryInterface $formFactory,
        private SerializerInterface $serializer
    ) {}
    public function handleStoringProduct(string $body, ?Product $product = null)
    {
        $data = json_decode($body, true);
        
        $product = $this->serializer->deserialize($body, Product::class,'json');
        $this->entityManager->persist($product);
        $this->entityManager->flush();
        return $product;
        //dd($product);

        
    }
}
