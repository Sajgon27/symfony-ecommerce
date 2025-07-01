<?php

namespace App\Service;

use App\Entity\Product;
use App\Form\ProductType;
use App\Service\Pagination\PagePaginator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\String\Slugger\AsciiSlugger;

class ProductService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private FormFactoryInterface $formFactory,
        private SerializerInterface $serializer,
       
    ) {}
    public function handleStoringProduct(string $body, ?Product $product = null)
    {


        $product = $this->serializer->deserialize($body, Product::class, 'json');

        //Creating slug
        $slugger = new AsciiSlugger();
        $slug = $slugger->slug($product->getName());
        $product->setSlug($slug);

        $this->entityManager->persist($product);
        $this->entityManager->flush();
        return $product;
    }
}
