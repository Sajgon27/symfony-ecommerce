<?php

namespace App\Service\Product;

use App\Entity\Product;
use App\Entity\ProductImage;
use App\Service\Product\ImagesUpload;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Serializer\SerializerInterface;

class Creator
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private SerializerInterface $serializer,
        private ParameterBagInterface $params,
        private SlugGenerator $slugGenerator,
        private ImagesUpload $imagesUpload,
    ) {}

    public function create(object $request, ?Product $product = null)
    {
        $data = $request->request->all();
        $product = new Product();

        $product->setName($data['name']);
        $product->setPrice(intval($data['price']));
        $product->setPromoPrice(intval($data['promoPrice']));
        $product->setStock(intval($data['stock']));
        $product->setEan($data['ean']);
        $product->setDescription($data['description']);

        $uniqueSlug = $this->slugGenerator->generateUniqueSlug($data['slug']);
        $product->setSlug($uniqueSlug);
        
        if ($data["isFeatured"] === "true") {
            $product->setIsFeatured(true);
        } else {
            $product->setIsFeatured(false);
        }

        $imageFileName = $this->imagesUpload->addMainImage($request->files->get('mainImage'), $uniqueSlug);
        $product->setMainImage($imageFileName);
        $this->imagesUpload->addGallery($request->files->get('gallery', []), $product);
      
        $this->entityManager->persist($product);
        $this->entityManager->flush();
        return $product;
    }
}
