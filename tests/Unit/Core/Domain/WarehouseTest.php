<?php

namespace App\Tests\Unit\Core\Domain;

use App\Core\Domain\Book;
use App\Core\Domain\Brand;
use App\Core\Domain\Exception\NoMoreSpaceException;
use App\Core\Domain\Warehouse;
use PHPUnit\Framework\TestCase;

class WarehouseTest extends TestCase
{
    /** @test */
    public function add_item(): void
    {
        $subject = new Warehouse('test', 'Address', 1, []);

        $brand = new Brand('Test Brand', 5);

        $book = new Book(
            'TESTBOOK1',
            'Test Book',
            100.0,
            $brand,
            'fantasy'
        );

        $subject->addItem($book);

        self::assertEquals([$book], $subject->getStock());
    }

    /** @test */
    public function add_item_but_no_more_space(): void
    {
        $this->expectException(NoMoreSpaceException::class);

        $subject = new Warehouse('test', 'Address', 1, []);

        $brand = new Brand('Test Brand', 5);

        $book = new Book(
            'TESTBOOK1',
            'Test Book',
            100.0,
            $brand,
            'fantasy'
        );

        $subject->addItem($book);
        $subject->addItem($book);
    }

    /** @test */
    public function get_item_by_sku(): void
    {
        $subject = new Warehouse('test', 'Address', 1, []);

        $brand = new Brand('Test Brand', 5);

        $book = new Book(
            'TESTBOOK1',
            'Test Book',
            100.0,
            $brand,
            'fantasy'
        );

        $subject->addItem($book);

        self::assertEquals($book, $subject->getItemBySku('TESTBOOK1'));
    }

    /** @test */
    public function remove_item_by_sku(): void
    {
        $subject = new Warehouse('test', 'Address', 1, []);

        $brand = new Brand('Test Brand', 5);

        $book = new Book(
            'TESTBOOK1',
            'Test Book',
            100.0,
            $brand,
            'fantasy'
        );

        $subject->addItem($book);

        self::assertTrue($subject->removeItemBySku('TESTBOOK1'));
    }

    /** @test */
    public function remove_item_by_sku_but_no_item_found(): void
    {
        $subject = new Warehouse('test', 'Address', 1, []);

        self::assertFalse($subject->removeItemBySku('TESTBOOK1'));
    }
}
