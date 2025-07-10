<?php

namespace App\Service\Order;

use App\Entity\Order;
use App\Entity\OrderAddres;
use App\Enum\AddressesType;
use App\Enum\OrderStatus;
use App\Enum\PaymentStatus;
use App\Service\PaymentService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class Creator
{
    public function __construct(
        private SerializerInterface $serializer,
        private EntityManagerInterface $entityManager,
        private PaymentService $paymentService,
    ) {}

    public function createOrder(string $data)
    {
        $order = $this->storeOrder($data);
       // dd($order);
        $response = $this->paymentService->createPayment($order);

        if ($response->getStatus() == 'SUCCESS') {
            return [
                    'success' => true,
                    'orderId' => $response->getResponse()->orderId,
                    'redirectUri' => $response->getResponse()->redirectUri,
                    'status' => $response->getResponse()->status
            ];
         }
        
    }

    public function storeOrder($data)
    {
        $jsonData = json_decode($data, 'json');

        $order = $this->serializer->deserialize($data, Order::class, 'json');
        $billingAddress = $this->serializer->deserialize($data, OrderAddres::class, 'json');
        $billingAddress->setType(AddressesType::BILLING);
        $orderNumber = 'ORD-' . date('Y') . '-' . time();

        $order->setOrderNumber($orderNumber);
        $order->setStatus(OrderStatus::WSTRZYMANE);
        $order->setPaymentStatus(PaymentStatus::WSTRZYMANE);
        $order->setOrderDate(new \DateTime());
        $order->setBillingAddress($billingAddress);
        // dd(json_decode($data));
        if ($jsonData['shipping'] === true) {
            $shippingAddress = new OrderAddres();

            $shippingAddress
                ->setName($jsonData['shippingName'])
                ->setSurname($jsonData['shippingSurname'])
                ->setAddressLine1($jsonData['shippingAddressLine1'])
                ->setAddressLine2($jsonData['shippingAddressLine2'])
                ->setCity($jsonData['shippingCity'])
                ->setPostalCode($jsonData['shippingPostalCode'])
                ->setCompany($jsonData['shippingCompany'])
                ->setType(AddressesType::SHIPPING);

            $order->setShippingAddress($shippingAddress);
        }

        foreach ($order->getOrderItems() as $orderItem) {
            $orderItem->setOrder($order);
        }

        $this->entityManager->persist($order);
        $this->entityManager->flush();
        return $order;
    }
}
