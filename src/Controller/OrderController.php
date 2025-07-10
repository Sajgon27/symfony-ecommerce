<?php

namespace App\Controller;

use App\Entity\Order;
use App\Repository\OrderRepository;
use App\Service\Order\Creator;
use App\Service\OrderService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

final class OrderController extends AbstractController
{

    #[Route('/orders', name: 'orders_index', methods: ["GET"])]
    public function index(OrderRepository $repository, SerializerInterface $serializer): JsonResponse
    {
        $orders = $serializer->serialize($repository->findAll(), 'json', ['groups' => 'order:index']);

        return JsonResponse::fromJsonString($orders);
    }

    #[Route('/orders/{id}', name: 'orders_show', methods: ['GET'])]
    public function show(Order $order): JsonResponse
    {
        return $this->json([
            'order' => $order
        ]);
    }

    #[Route('/orders/{id}', name: "order_delete", methods: ["DELETE"])]
    public function destroy(Order $order, EntityManagerInterface $entityManager): JsonResponse
    {


        $entityManager->remove($order);
        $entityManager->flush();
        return $this->json([
            "message" => "Order delted",

        ], 202);
    }

    #[Route('/orders', name: 'orders_store', methods: ["POST"])]
    public function store(Request $request, OrderService $service, Creator $creator): JsonResponse
    {

       // $order = $service->handleStoringOrder($request->getContent());
        $order = $creator->createOrder($request->getContent());

        return $this->json($order);
    }
}
