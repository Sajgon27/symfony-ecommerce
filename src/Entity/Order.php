<?php

namespace App\Entity;

use App\Enum\OrderStatus;
use App\Enum\PaymentStatus;
use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Serializer\Attribute\SerializedName;
use Symfony\Component\Serializer\Attribute\SerializedPath;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["order:index"])]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Groups(["order:index"])]
    private string $orderNumber;

    #[ORM\Column(enumType: OrderStatus::class)]
    #[Groups(["order:index"])]
    private ?OrderStatus $status = null;

    #[ORM\Column(enumType: PaymentStatus::class)]
    private ?PaymentStatus $paymentStatus = null;

    #[ORM\Column]
    #[Groups(["order:index"])]
    private ?int $totalAmount = null;

    #[ORM\Column]
    #[Groups(["order:index"])]
    private ?\DateTime $orderDate = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $paymentMethod = null;

    #[ORM\Column(length: 20)]
    private ?string $phone = null;

    #[ORM\Column(length: 20)]
    private ?string $nip = null;

    #[ORM\Column(length: 50)]
    #[Groups(["order:index"])]
    private ?string $email = null;

    #[ORM\Column]
    private bool $invoice = false;

    /**
     * @var Collection<int, OrderItem>
     */
    #[ORM\OneToMany(targetEntity: OrderItem::class, mappedBy: 'order', cascade: ['persist'])]
    #[SerializedName('order_items')]
    private Collection $orderItems;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?OrderAddres $billingAddress = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?OrderAddres $shippingAddress = null;

    

    public function __construct()
    {
        $this->orderItems = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrderNumber(): ?string
    {
        return $this->orderNumber;
    }

    public function setOrderNumber(string $orderNumber): static
    {
        $this->orderNumber = $orderNumber;

        return $this;
    }

    public function getStatus(): ?OrderStatus
    {
        return $this->status;
    }

    public function setStatus(OrderStatus $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getPaymentStatus(): ?PaymentStatus
    {
        return $this->paymentStatus;
    }

    public function setPaymentStatus(PaymentStatus $paymentStatus): static
    {
        $this->paymentStatus = $paymentStatus;

        return $this;
    }

    public function getTotalAmount(): ?int
    {
        return $this->totalAmount;
    }

    public function setTotalAmount(int $totalAmount): static
    {
        $this->totalAmount = $totalAmount;

        return $this;
    }

    public function getOrderDate(): ?\DateTime
    {
        return $this->orderDate;
    }

    public function setOrderDate(\DateTime $orderDate): static
    {
        $this->orderDate = $orderDate;

        return $this;
    }

    public function getPaymentMethod(): ?string
    {
        return $this->paymentMethod;
    }

    public function setPaymetyMethod(?string $paymentMethod): static
    {
        $this->paymentMethod = $paymentMethod;

        return $this;
    }

    /**
     * @return Collection<int, OrderItem>
     */
    public function getOrderItems(): Collection
    {
        return $this->orderItems;
    }

    public function addOrderItem(OrderItem $orderItem): static
    {
        if (!$this->orderItems->contains($orderItem)) {
            $this->orderItems->add($orderItem);
            $orderItem->setOrder($this);
        }

        return $this;
    }

    public function removeOrderItem(OrderItem $orderItem): static
    {
        if ($this->orderItems->removeElement($orderItem)) {
            // set the owning side to null (unless already changed)
            if ($orderItem->getOrder() === $this) {
                $orderItem->setOrder(null);
            }
        }

        return $this;
    }

    public function setPaymentMethod(?string $paymentMethod): static
    {
        $this->paymentMethod = $paymentMethod;

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

    public function getNip(): ?string
    {
        return $this->nip;
    }

    public function setNip(string $nip): static
    {
        $this->nip = $nip;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function isInvoice(): ?bool
    {
        return $this->invoice;
    }

    public function setInvoice(bool $invoice): static
    {
        $this->invoice = $invoice;

        return $this;
    }

    public function getBillingAddress(): ?OrderAddres
    {
        return $this->billingAddress;
    }

    public function setBillingAddress(OrderAddres $billingAddress): static
    {
        $this->billingAddress = $billingAddress;

        return $this;
    }

    public function getShippingAddress(): ?OrderAddres
    {
        return $this->shippingAddress;
    }

    public function setShippingAddress(?OrderAddres $shippingAddress): static
    {
        $this->shippingAddress = $shippingAddress;

        return $this;
    }
}
