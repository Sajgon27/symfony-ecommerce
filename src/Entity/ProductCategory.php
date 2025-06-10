<?php

namespace App\Entity;

use App\Repository\ProductCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ProductCategoryRepository::class)]
class ProductCategory
{
    #[Groups(["category:read"])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(["category:read"])]
    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[Groups(["category:read"])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $meta_title = null;

    #[Groups(["category:read"])]
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $meta_description = null;

    #[Groups(["category:read"])]
    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'childCategories')]
    private ?self $parentCategory = null;

    /**
     * @var Collection<int, self>
     */
    #[ORM\OneToMany(targetEntity: self::class, mappedBy: 'parentCategory')]
    private Collection $childCategories;

    public function __construct()
    {
        $this->childCategories = new ArrayCollection();
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

    public function getMetaTitle(): ?string
    {
        return $this->meta_title;
    }

    public function setMetaTitle(?string $meta_title): static
    {
        $this->meta_title = $meta_title;

        return $this;
    }

    public function getMetaDescription(): ?string
    {
        return $this->meta_description;
    }

    public function setMetaDescription(?string $meta_description): static
    {
        $this->meta_description = $meta_description;

        return $this;
    }

    public function getParentCategory(): ?self
    {
        return $this->parentCategory;
    }

    public function setParentCategory(?self $parentCategory): void
    {
        $this->parentCategory = $parentCategory;
    }

    // Children
    /**
     * @return Collection<int, self>
     */
    public function getChildCategories(): Collection
    {
        return $this->childCategories;
    }

    public function addChildCategory(self $child): void
    {
        if (!$this->childCategories->contains($child)) {
            $this->childCategories[] = $child;
            $child->setParentCategory($this);
        }
    }

    public function removeChildCategory(self $child): void
    {
        if ($this->childCategories->removeElement($child)) {
            if ($child->getParentCategory() === $this) {
                $child->setParentCategory(null);
            }
        }
    }
}
