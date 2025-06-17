<?php

namespace App\Controller;

use App\Repository\OrderRepository;
use App\Service\OrderService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

final class OrderController extends AbstractController
{
   
    #[Route('/orders', name:'orders_index', methods:["GET"])]
    public function index(OrderRepository $repository, SerializerInterface $serializer):JsonResponse
     {
        $orders = $serializer->serialize($repository->findAll(), 'json');

        return JsonResponse::fromJsonString($orders);
    }
    
    #[Route('/orders', name:'orders_store', methods:["POST"])]
    public function store(Request $request, OrderService $service):JsonResponse
     {
        $order = $service->handleStoringOrder($request->getContent());
        return JsonResponse::fromJsonString($order);
    }
}
