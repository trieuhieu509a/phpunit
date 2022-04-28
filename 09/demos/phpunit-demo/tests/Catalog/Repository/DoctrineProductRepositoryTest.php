<?php
declare(strict_types=1);

namespace App\Catalog\Repository;

use App\Catalog\Value\Amount;
use App\Catalog\Value\Product;
use App\Tests\IntegrationTestCase;

/** @covers \App\Catalog\Repository\DoctrineProductRepository */
final class DoctrineProductRepositoryTest extends IntegrationTestCase
{
    /** @test */
    public function findProducts_WithoutDiscount_ReturnsFullPriceProducts(): void
    {
        $this->initializeContainer();
        $this->resetDatabase();
        $this->insertRecord('product', [
            'name' => 'Concert',
            'cost' => 1000,
            'markup' => 10
        ]);

        /** @var DoctrineProductRepository $repository */
        $repository = $this->diContainer->get(DoctrineProductRepository::class);

        self::assertEquals(
            [
                new Product('Concert', new Amount(1100))
            ],
            $repository->findProducts()
        );
    }

    /** @test */
    public function findProducts_WithDiscount_ReturnsDiscountedProducts(): void
    {
        $this->initializeContainer();
        $this->resetDatabase();
        $this->insertRecord('product', [
            'name' => 'Concert',
            'cost' => 1000,
            'markup' => 10
        ]);
        $this->insertRecord('discount', [
            'product_id' => 1,
            'name' => 'Discount Name',
            'type' => 'percent',
            'value' => 50
        ]);

        /** @var DoctrineProductRepository $repository */
        $repository = $this->diContainer->get(DoctrineProductRepository::class);

        self::assertEquals(
            [
                new Product('Concert', new Amount(550)),
            ],
            $repository->findProducts()
        );
    }
}
