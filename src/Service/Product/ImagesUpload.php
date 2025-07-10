<?php

namespace App\Service\Product;

use App\Entity\ProductImage;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class ImagesUpload
{
    public function __construct(
        private ParameterBagInterface $params
    ) {}

    public function addMainImage($productImage, $slug)
    {
        // $productImage = $request->files->get('main_image');
        if (!$productImage) {
            return;
        };

        $uploadDir = 'uploads/' . $slug;
        $destination = $this->params->get('kernel.project_dir') . '/public/' . $uploadDir;

        $newFilename = uniqid() . '.' . $productImage->guessExtension();
        $productImage->move($destination, $newFilename);

        return $newFilename;
        
    }
    public function addGallery($gallery, $product)
    {
        //$gallery = $request->files->get('gallery', []);
        $uploadDir = 'uploads/' . $product->getSlug();
        $destination = $this->params->get('kernel.project_dir') . '/public/' . $uploadDir;

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
    }
}
