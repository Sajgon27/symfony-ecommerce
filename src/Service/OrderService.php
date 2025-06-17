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
       // dd($raw_data);
        $order = $this->serializer->deserialize($data,Order::class,'json');
       // dd(gettype($data->getOrderItems()));
       $i = 0;
        foreach($order->getOrderItems() as $order) {
            $i++;
            $order_item = $this->serializer->deserialize($order, OrderItem::class, "json");
            $order->addOrderItem($order_item);
        }
        //dd($i);
       $this->em->persist($order);
       $this->em->flush();
        return $order->getOrderNumber();
    }
} 