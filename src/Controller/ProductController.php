<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use App\Service\Product\Creator;
use App\Service\ProductService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

final class ProductController extends AbstractController
{
    #[Route('/product', name: 'app_product', methods: ["GET"])]
    public function index(
        Request $request,
        ProductRepository $repository,
        SerializerInterface $serializer,
        TranslatorInterface $translator
    ): JsonResponse {
        $page = max(1, (int) $request->query->get('page', 1));
        $limit = 30;
        $offset = ($page - 1) * $limit;

        $products = $repository->findBy([], null, $limit, $offset);
        $total = count($repository->findAll());

        $label = $translator->trans('element.count', [
            '%count%' => $total
        ]);

        $data = [
            'page' => $page,
            'limit' => $limit,
            'label' => $label,
            'total' => $total,
            'products' => json_decode($serializer->serialize($products, 'json', ['groups' => 'products:index']), true),
        ];

        return new JsonResponse($data);
    }




    #[Route('/product/{id}', name: "show_product", methods: ["GET"])]
    public function show(Product $product, SerializerInterface $serializer): JsonResponse
    {
        $product = $serializer->serialize([
            "product" => $product,
            "message" => "success"
        ], 'json', ['groups' => 'products:show']);
        return JsonResponse::fromJsonString($product);
    }

    #[Route('/product/slug/{slug:product}', name: "show_by_slug_product", methods: ["GET"])]
    public function showBySlug(Product $product, SerializerInterface $serializer): JsonResponse
    {
        $product = $serializer->serialize([
            "product" => $product,
            "message" => "success"
        ], 'json', ['groups' => 'products:show']);
        return JsonResponse::fromJsonString($product);
    }

    #[Route('/product/{id}', name: "product_delte", methods: ["DELETE"])]
    public function destroy(Product $product, EntityManagerInterface $entityManager, Filesystem $filesystem): JsonResponse
    {
        $path = $this->getParameter('kernel.project_dir') . '/public/uploads/' . $product->getSlug();

        if ($filesystem->exists($path)) {
            $filesystem->remove($path);
        }

        $entityManager->remove($product);
        $entityManager->flush();
        return $this->json([
            "message" => "Product delted",

        ], 202);
    }

    #[Route('/product', name: "product_store", methods: ["POST"])]
    public function store(Request $request, ProductService $productService, Creator $creator): JsonResponse
    {

        //   $product = $productService->handleStoringProduct($request);
        $product = $creator->create($request);

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

    #[Route('/product/{id}', name: "product_update", methods: ['PATCH'])]
    public function update(Request $request, Product $product, ProductService $productService): JsonResponse
    {
        [$product, $errors] = $productService->handleStoringProduct($request->getContent(), $product);

        return $this->json([
            'message' => 'eoo'
        ]);
    }

    #[Route('/products/featured', name: 'products_featured', methods: ['GET'])]
    public function getFeatured(ProductRepository $repository): JsonResponse
    {
        $products = $repository->findFeatured();
        return $this->json(
            [
                "products" => $products
            ],
            200,
            [],
            ['groups' => ['products:index']]
        );
    }

    #[Route('/products/selected', name: 'products_selected', methods: ['GET', 'OPTIONS '])]
    public function getSelected(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $productIds = $request->query->all();
        $products = $entityManager->getRepository(Product::class)
            ->findBy(['id' => $productIds]);

        return $this->json([
            'products' => $products
        ]);
    }

    #[Route('/products/basic', name: 'products_basic', methods: ['GET', 'OPTIONS'])]
    public function getProductBasicInfo(Request $request, ProductRepository $repository): JsonResponse
    {
        $productIds = $request->query->all('id');

        $products = $repository->findBy(['id' => $productIds]);
        $productData = [];
        foreach ($products as $product) {
            $productData[] = [
                'id' => $product->getId(),
                'name' => $product->getName(),
                'price' => $product->getPrice(),
                'mainImage' => $product->getMainImage(),
                'slug' => $product->getSlug()
            ];
        }
        return $this->json([
            'data' => $productData
        ]);
    }
}
