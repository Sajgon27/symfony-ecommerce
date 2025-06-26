<?php

namespace App\Controller;

use App\Entity\ProductCategory;
use App\Repository\ProductCategoryRepository;
use App\Service\ProductCategoryService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

final class ProductCategoryController extends AbstractController
{
    #[Route('/category', name: 'product_category_index', methods: ['GET']),]
    public function index(ProductCategoryRepository $repository, SerializerInterface $serializer): JsonResponse
    {
        $categories = $serializer->serialize($repository->findAll(), 'json', ['groups' => 'category:read']);
        return JsonResponse::fromJsonString($categories, 200);
    }

    #[Route('/category/{id}', name: 'product_category_show', methods: ['GET'])]
    public function show(ProductCategory $category, SerializerInterface $serializer)
    {
        $category = $serializer->serialize([
            "category" => $category,
            "message" => "success"
        ], 'json');
        return JsonResponse::fromJsonString($category);
    }


    #[Route('/category', name: 'product_category_store', methods: ['POST'])]
    public function store(Request $request, ProductCategoryService $service): JsonResponse
    {
 //dd($request->getContent());
        [$category, $errors] = $service->handleStoringCategory($request->getContent());
        if (!empty($errors)) {
            return $this->json([
                'message' => 'errors',
                'errors' => $errors
            ], 400);
        };

        return $this->json([
            'message' => 'Category added succesfully',
            'data' => [
                "name" => $category->getName(),
                "id" => $category->getId()
            ]
        ], 202);
    }
    #[Route('/category/{id}', name: "category_delte", methods: ["DELETE"])]
    public function destroy(ProductCategory $category, EntityManagerInterface $entityManager): JsonResponse
    {

        $grandparent = $category->getParentCategory();
        foreach ($category->getChildCategories() as $child) {
            $child->setParentCategory($grandparent);
        }

        $entityManager->remove($category);
        $entityManager->flush();
        return $this->json([
            "categoryid" => $category->getId(),
            "parent" => $category->getName(),
            "message" => "category delted",
        ], 200);
    }
}
