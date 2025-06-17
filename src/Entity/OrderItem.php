<?php

namespace App\Entity;

use App\Repository\OrderItemRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderItemRepository::class)]
class OrderItem
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Order $order_id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Product $product_id = null;

    #[ORM\Column(length: 255)]
    private ?string $product_name = null;

    #[ORM\Column(length: 40, nullable: true)]
    private ?string $product_sku = null;

    #[ORM\Column]
    private ?int $quantity = null;

    #[ORM\Column]
    private ?int $unit_price = null;

    #[ORM\ManyToOne(targetEntity:Order::class ,inversedBy: 'orderItems')]
    private ?Order $order = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrderId(): ?Order
    {
        return $this->order_id;
    }

    public function setOrderId(?Order $order_id): static
    {
        $this->order_id = $order_id;

        return $this;
    }

    public function getProductId(): ?Product
    {
        return $this->product_id;
    }

    public function setProductId(?Product $product_id): static
    {
        $this->product_id = $product_id;

        return $this;
    }

    public function getProductName(): ?string
    {
        return $this->product_name;
    }

    public function setProductName(string $product_name): static
    {
        $this->product_name = $product_name;

        return $this;
    }

    public function getProductSku(): ?string
    {
        return $this->product_sku;
    }

    public function setProductSku(?string $product_sku): static
    {
        $this->product_sku = $product_sku;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getUnitPrice(): ?int
    {
        return $this->unit_price;
    }

    public function setUnitPrice(int $unit_price): static
    {
        $this->unit_price = $unit_price;

        return $this;
    }

    public function getOrder(): ?Order
    {
        return $this->order;
    }

    public function setOrder(?Order $order): static
    {
        $this->order = $order;

        return $this;
    }
}
