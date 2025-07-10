<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["products:index","products:show"])]
    private ?int $id = null;

    #[Groups(["products:index","products:show"])]
    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[Groups(["products:show"])]
    #[ORM\Column(type: Types::TEXT, nullable:true)]
    private ?string $description = null;

    #[ORM\Column(nullable: true)]
     #[Groups(["products:index","products:show"])]
    private ?string $ean = null;

    #[ORM\Column(length: 255)]
    #[Groups(["products:index","products:show"])]
    private ?string $mainImage = null;

    #[ORM\Column]
       #[Groups(["products:index","products:show"])]
    private ?int $price = null;

    #[ORM\Column]
       #[Groups(["products:index","products:show"])]
    private ?int $promoPrice = null;

    #[ORM\Column]
       #[Groups(["products:index","products:show"])]
    private ?int $stock = null;

    #[ORM\Column]
       #[Groups(["products:index","products:show"])]
    private ?bool $isFeatured = false;

    #[ORM\Column(unique:true)]
       #[Groups(["products:index","products:show"])]
    private ?string $slug = null;

    /**
     * @var Collection<int, ProductCategory>
     */
    #[ORM\ManyToMany(targetEntity: ProductCategory::class, inversedBy: 'products')]
      #[Groups(["products:show"])]
    private Collection $category;

    /**
     * @var Collection<int, ProductImage>
     */
    #[ORM\OneToMany(targetEntity: ProductImage::class, mappedBy: 'product', orphanRemoval: true, cascade:['persist'])]
      #[Groups(["products:show"])]
    private Collection $productImages;

    public function __construct()
    {
        $this->category = new ArrayCollection();
        $this->productImages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getEan(): ?int
    {
        return $this->ean;
    }

    public function setEan(?int $ean): static
    {
        $this->ean = $ean;

        return $this;
    }

    public function getMainImage(): ?string
    {
        return $this->mainImage;
    }

    public function setMainImage(string $mainImage): static
    {
        $this->mainImage = $mainImage;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock): static
    {
        $this->stock = $stock;

        return $this;
    }

    public function isFeatured(): ?bool
    {
        return $this->isFeatured;
    }

    public function setIsFeatured(bool $isFeatured): static
    {
        $this->isFeatured = $isFeatured;

        return $this;
    }

    /**
     * @return Collection<int, ProductCategory>
     */
    public function getCategory(): Collection
    {
        return $this->category;
    }

    public function addCategory(ProductCategory $category): static
    {
        if (!$this->category->contains($category)) {
            $this->category->add($category);
        }

        return $this;
    }

    public function removeCategory(ProductCategory $category): static
    {
        $this->category->removeElement($category);

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function getPromoPrice(): ?int
    {
        return $this->promoPrice;
    }

    public function setPromoPrice(int $promoPrice): static
    {
        $this->promoPrice = $promoPrice;

        return $this;
    }

    /**
     * @return Collection<int, ProductImage>
     */
    public function getProductImages(): Collection
    {
        return $this->productImages;
    }

    public function addProductImage(ProductImage $productImage): static
    {
        if (!$this->productImages->contains($productImage)) {
            $this->productImages->add($productImage);
            $productImage->setProduct($this);
        }

        return $this;
    }

    public function removeProductImage(ProductImage $productImage): static
    {
        if ($this->productImages->removeElement($productImage)) {
            // set the owning side to null (unless already changed)
            if ($productImage->getProduct() === $this) {
                $productImage->setProduct(null);
            }
        }

        return $this;
    }
}
