<?php 
namespace App\Service;

use App\Entity\ProductCategory;
use App\Form\ProductCategoryType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;

class ProductCategoryService{
    public function __construct(
        private FormFactoryInterface $formFactory,
        private EntityManagerInterface $entityManager
    )
    {}
    public function handleStoringCategory($body) {
        $data = json_decode($body, 'json');
        $category = new ProductCategory();
        $form = $this->formFactory->create(ProductCategoryType::class, $category);
        $form->submit($data);

        if(!$form->isValid()) {
            $errors = [];
            foreach ($form->getErrors(true) as $error) {
                   $errors[] = [
                    'field' => $error->getOrigin()->getName(),
                    'message' => $error->getMessage()
                ];
            };
            return [null, $errors ];
        }
 
        $category = $form->getData($data);
        $this->entityManager->persist($category);
        $this->entityManager->flush();
        return [$category, null];
    }
}