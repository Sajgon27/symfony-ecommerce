<?php

namespace App\Service;

use App\Entity\Product;
use App\Form\ProductType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;

class ProductService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private FormFactoryInterface $formFactory
    ) {}
    public function handleStoringProduct(string $body)
    {
        $data = json_decode($body, true);
        $product = new Product();
        $form = $this->formFactory->create(ProductType::class, $product);

        $form->submit($data);


        if (!$form->isValid()) {
            $errors = [];
            foreach ($form->getErrors(true) as $error) {
                $errors[] = [
                    'field' => $error->getOrigin()->getName(),
                    'message' => $error->getMessage()
                ];
            }
            return [null, $errors];
        }



        $product = $form->getData();
        $this->entityManager->persist($product);
        $this->entityManager->flush();

        return [$product, []];
    }
}
