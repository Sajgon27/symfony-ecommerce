<?php 

namespace App\Service;

use App\Entity\Order;
use App\Entity\OrderItem;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class OrderService {
    public function __construct(
        private SerializerInterface $serializer,
        private EntityManagerInterface $em
    ) 
    {}
    public function handleStoringOrder(string $data) 
    {
        $raw_data = $this->serializer->serialize($data, 'json');
     
        $order = $this->serializer->deserialize($data,Order::class,'json');
      
       $i = 0;
        foreach($order->getOrderItems() as $order) {
            $i++;
            $order_item = $this->serializer->deserialize($order, OrderItem::class, "json");
            $order->addOrderItem($order_item);
        }
       $this->em->persist($order);
       $this->em->flush();
        return $order->getOrderNumber();
    }
} 