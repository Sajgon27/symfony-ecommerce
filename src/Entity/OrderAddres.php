<?php

namespace App\Entity;

use App\Enum\AddressesType;
use App\Repository\OrderAddresRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderAddresRepository::class)]
class OrderAddres
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Order $order_id = null;

    #[ORM\Column(enumType: AddressesType::class)]
    private ?AddressesType $type = null;

    #[ORM\Column(length: 100)]
    private ?string $first_name = null;

    #[ORM\Column(length: 100)]
    private ?string $last_name = null;

    #[ORM\Column(length: 255)]
    private ?string $address_line_1 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $address_line_2 = null;

    #[ORM\Column(length: 255)]
    private ?string $city = null;

    #[ORM\Column(length: 10)]
    private ?string $postal_code = null;

    #[ORM\Column(length: 20)]
    private ?string $phone = null;

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

    public function getType(): ?AddressesType
    {
        return $this->type;
    }

    public function setType(AddressesType $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setFirstName(string $first_name): static
    {
        $this->first_name = $first_name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): static
    {
        $this->last_name = $last_name;

        return $this;
    }

    public function getAddressLine1(): ?string
    {
        return $this->address_line_1;
    }

    public function setAddressLine1(string $address_line_1): static
    {
        $this->address_line_1 = $address_line_1;

        return $this;
    }

    public function getAddressLine2(): ?string
    {
        return $this->address_line_2;
    }

    public function setAddressLine2(?string $address_line_2): static
    {
        $this->address_line_2 = $address_line_2;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postal_code;
    }

    public function setPostalCode(string $postal_code): static
    {
        $this->postal_code = $postal_code;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }
}
