<?php

namespace App\Service;

use App\Entity\Product;
use App\Entity\ProductImage;
use App\Form\ProductType;
use App\Service\Pagination\PagePaginator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\String\Slugger\AsciiSlugger;

class ProductService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private SerializerInterface $serializer,
        private ParameterBagInterface $params,
    ) {}
    public function handleStoringProduct(object $request, ?Product $product = null)
    {
        // $product = $this->serializer->deserialize($body, Product::class, 'form-data');
        $data = $request->request->all();
        $product = new Product();
        $product->setName($data['name']);
        $product->setPrice(intval($data['price']));
        $product->setPromoPrice(intval($data['promo_price']));
        $product->setStock(intval($data['stock']));
        $product->setEan($data['ean']);

        $product->setSlug($data['slug']);
        $product->setDescription($data['description']);
        if ($data["is_featured"] === "true") {
            $product->setIsFeatured(true);
        } else {
            $product->setIsFeatured(false);
        }



        $productImage = $request->files->get('main_image');
        if (!$productImage) {
            return;
        };

        $uploadDir = 'uploads/' . $product->getSlug();
        $destination = $this->params->get('kernel.project_dir') . '/public/' . $uploadDir;

        $newFilename = uniqid() . '.' . $productImage->guessExtension();
        $productImage->move($destination, $newFilename);

        // Set relative path to the entity
        $product->setMainImage($newFilename);

       // dd($data);
        $gallery = $request->files->get('gallery', []);
        foreach ($gallery as $file) {
            if ($file->isValid()) {
                $newFilename = uniqid() . '.' . $file->guessExtension();
                $file->move($destination, $newFilename);
                $image = new ProductImage();

                $image->setProduct($product);
                $image->setFilename($newFilename);
                $product->addProductImage($image);
            }
        }

        
        $this->entityManager->persist($product);
        $this->entityManager->flush();
        return $product;
    }
}
