<?php

namespace App\Repository;

use App\Entity\Color;
use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @extends ServiceEntityRepository<Color>
 */
class ColorRepository extends ServiceEntityRepository
{
    private const COLORS = [
        1 => [
            'id' => '1',
            'name' => 'rose ashes',
            'hexColor' => '#f5eae4',
        ],

        2 => [
            'id' => '2',
            'name' => 'ultramarine',
            'hexColor' => '#0437F2',
        ],

        3 => [
            'id' => '3',
            'name' => 'purple',
            'hexColor' => '#A020F0',
        ],

    ];

    public function __construct(ManagerRegistry $registry, private readonly SerializerInterface $serializer)
    {
        parent::__construct($registry, Color::class);
    }

    public function hydrate(array $data): Color
    {
        return $this->serializer->denormalize($data, Color::class);
    }

    public function all(): array
    {
        $result = [];
        foreach (self::COLORS as $color) {
            $result[] = $this->hydrate($color);
        }
        return $result;
    }
    // rose ashes
    //
    //
}
