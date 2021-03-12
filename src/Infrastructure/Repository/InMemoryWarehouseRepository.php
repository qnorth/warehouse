<?php

namespace App\Infrastructure\Repository;

use App\Core\Domain\Repository\WarehouseRepositoryInterface;
use App\Core\Domain\Warehouse;

class InMemoryWarehouseRepository implements WarehouseRepositoryInterface
{
    /**
     * @var Warehouse[]
     */
    private array $warehouses;

    /**
     * InMemoryWarehouseRepository constructor.
     * @param array $warehouses
     */
    public function __construct(array $warehouses = [])
    {
        $this->warehouses = $warehouses;
    }

    /**
     * @param Warehouse $warehouse
     * @return void
     */
    public function save(Warehouse $warehouse): void
    {
        $this->warehouses[] = $warehouse;
    }

    /**
     * @return Warehouse[]
     */
    public function findAll(): array
    {
        return $this->warehouses;
    }
}
