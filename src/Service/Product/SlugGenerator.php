<?php
namespace App\Service\Product;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;

class SlugGenerator
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    )
    { }
         public function generateUniqueSlug(string $baseSlug): string
    {
        $slug = $baseSlug;
        $originalSlug = $baseSlug;
        $counter = 1;
        while ($this->slugExists($slug)) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }
       
        return $slug;
    }

    private function slugExists(string $slug): bool
    {
        return $this->entityManager->getRepository(Product::class)
            ->findOneBy(['slug' => $slug]) !== null;
    }
} 