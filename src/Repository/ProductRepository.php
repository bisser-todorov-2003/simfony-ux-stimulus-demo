<?php

namespace App\Repository;

use App\Entity\Color;
use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @extends ServiceEntityRepository<Product>
 */
class ProductRepository extends ServiceEntityRepository
{
    private ManagerRegistry $registry;

    private const PRODUCTS = [
        1 => [
            'id' => 1,
            'name' => 'Product 1',
            'description' => 'Description of product 1',
            'price' => 100.00,
        ],
        2 => [
            'id' => 2,
            'name' => 'Product 2',
            'description' => 'Description of product 2',
            'price' => 200.00,
        ],
        3 => [
            'id' => 3,
            'name' => 'Product 3',
            'description' => 'Description of product 3',
            'price' => 300.00,
        ],
    ];

    public function __construct(ManagerRegistry $registry, private readonly SerializerInterface $serializer)
    {
        $this->registry = $registry;
        parent::__construct($registry, Product::class);
    }

    public function get(int $id): Product
    {
        return $this->hydrate(self::PRODUCTS[$id] ?? []);
    }
    public function all(): array
    {
        $all = [];
        foreach (self::PRODUCTS as $product) {
            $all[] = $this->hydrate($product);
        }

        return $all;
    }

    protected function hydrate(array $data): Product
    {
        $colors = $this->registry->getManager()->getRepository(Color::class)->all();
        $product = $this->serializer->denormalize($data, Product::class);
foreach ($colors as $color) {
    $product->addColor($color);
}
        return $product;
    }
}
