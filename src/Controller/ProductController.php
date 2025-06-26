<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use App\Service\ProductService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

final class ProductController extends AbstractController
{
    #[Route('/product', name: 'app_product', methods: ["GET"])]
    public function index(ProductRepository $repository, SerializerInterface $serializer): JsonResponse
    {
        $products = $serializer->serialize($repository->findAll(), 'json');
        return JsonResponse::fromJsonString($products);
    }

    #[Route('/product/{id}', name: "show_product", methods: ["GET"])]
    public function show(Product $product, SerializerInterface $serializer): JsonResponse
    {
        $product = $serializer->serialize([
            "product" => $product,
            "message" => "success"
        ], 'json');
        return JsonResponse::fromJsonString($product);
    }

    #[Route('/product/{id}', name: "product_delte", methods: ["DELETE"])]
    public function destroy(Product $product, EntityManagerInterface $entityManager): JsonResponse
    {
        $entityManager->remove($product);
        $entityManager->flush();
        return $this->json([
            "message" => "Product delted",

        ], 202);
    }

    #[Route('/product', name: "product_store", methods: ["POST"])]
    public function store(Request $request, ProductService $productService): JsonResponse
    {
        $product = $productService->handleStoringProduct($request->getContent());
       // if (!empty($errors)) {
        //    return $this->json([
       ////         "errors" => $errors
      //      ], 400);
      //  }

        return $this->json([
            'data' => [
                'id' => $product->getId(),
                'name' => $product->getName(),
                'price' => $product->getPrice(),
                'stock' => $product->getStock(),
            ],
            "message" => "Product created"
        ], 200);
    }

    #[Route('/product/{id}', name:"product_update", methods:['PATCH'])]
    public function update(Request $request, Product $product, ProductService $productService):JsonResponse
    {
       [$product, $errors] = $productService->handleStoringProduct($request->getContent(), $product);

        return $this->json([
            'message'=> 'eoo'
        ]);
    }

    #[Route('/products/featured', name:'products_featured', methods:['GET'])]
    public function getFeatured(ProductRepository $repository):JsonResponse
    {
        $products = $repository->findFeatured();
        return $this->json([
            "products"=> $products
        ]);
    }
}
