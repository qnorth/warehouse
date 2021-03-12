<?php

namespace App\Tests;

use App\Core\Application\Exception\WarehousesAreFullException;
use App\Core\Application\WarehouseService;
use App\Core\Domain\Book;
use App\Core\Domain\Brand;
use App\Infrastructure\Repository\InMemoryWarehouseRepository;
use PHPUnit\Framework\TestCase;

class AcceptanceTests extends TestCase
{
    /** @test */
    public function adds_more_products_and_prints_the_contents_of_the_warehouse(): void
    {
        $warehouseService = new WarehouseService(new InMemoryWarehouseRepository());

        $warehouseService->createNew([
            'name' => 'Test 1',
            'address' => 'Address 1',
            'capacity' => 1,
        ]);

        $warehouseService->createNew([
            'name' => 'Test 2',
            'address' => 'Address 2',
            'capacity' => 1,
        ]);

        $brand = new Brand('Test Brand', 5);

        $bookList = [
            new Book(
                'TESTBOOK1',
                'Test Book 1',
                100.0,
                $brand,
                'fantasy'
            ),
            new Book(
                'TESTBOOK2',
                'Test Book 2',
                100.0,
                $brand,
                'fantasy'
            ),
        ];

        $warehouseService->addProducts($bookList);

        self::assertEquals($bookList, $warehouseService->getAllContent());
    }

    /** @test */
    public function adds_more_products_but_not_enough_space(): void
    {
        $this->expectException(WarehousesAreFullException::class);

        $warehouseService = new WarehouseService(new InMemoryWarehouseRepository());

        $warehouseService->createNew([
            'name' => 'Test 1',
            'address' => 'Address 1',
            'capacity' => 1,
        ]);

        $warehouseService->createNew([
            'name' => 'Test 2',
            'address' => 'Address 2',
            'capacity' => 1,
        ]);

        $brand = new Brand('Test Brand', 5);

        $bookList = [
            new Book(
                'TESTBOOK1',
                'Test Book 1',
                100.0,
                $brand,
                'fantasy'
            ),
            new Book(
                'TESTBOOK2',
                'Test Book 2',
                100.0,
                $brand,
                'fantasy'
            ),
            new Book(
                'TESTBOOK3',
                'Test Book 3',
                100.0,
                $brand,
                'fantasy'
            ),
        ];

        $warehouseService->addProducts($bookList);
    }

    /** @test */
    public function gets_products_but_served_by_multiple_warehouses_together(): void
    {
        $warehouseService = new WarehouseService(new InMemoryWarehouseRepository());

        $brand = new Brand('Test Brand', 5);

        $book1 = new Book(
            'TESTBOOK1',
            'Test Book 1',
            100.0,
            $brand,
            'fantasy'
        );

        $book2 = new Book(
            'TESTBOOK2',
            'Test Book 2',
            100.0,
            $brand,
            'fantasy'
        );

        $warehouseService->createNew([
            'name' => 'Test 1',
            'address' => 'Address 1',
            'capacity' => 1,
            'stock' => [$book1],
        ]);

        $warehouseService->createNew([
            'name' => 'Test 2',
            'address' => 'Address 2',
            'capacity' => 1,
            'stock' => [$book2],
        ]);

        self::assertEquals([$book1, $book2], $warehouseService->getProducts(['TESTBOOK2', 'TESTBOOK1']));
    }

    /** @test */
    public function removes_products(): void
    {
        $warehouseService = new WarehouseService(new InMemoryWarehouseRepository());

        $brand = new Brand('Test Brand', 5);

        $book1 = new Book(
            'TESTBOOK1',
            'Test Book 1',
            100.0,
            $brand,
            'fantasy'
        );

        $book2 = new Book(
            'TESTBOOK2',
            'Test Book 2',
            100.0,
            $brand,
            'fantasy'
        );

        $warehouseService->createNew([
            'name' => 'Test 1',
            'address' => 'Address 1',
            'capacity' => 1,
            'stock' => [$book1],
        ]);

        $warehouseService->createNew([
            'name' => 'Test 2',
            'address' => 'Address 2',
            'capacity' => 1,
            'stock' => [$book2],
        ]);

        $warehouseService->removeProducts(['TESTBOOK1']);

        self::assertEquals([$book2], $warehouseService->getAllContent());
    }
}
