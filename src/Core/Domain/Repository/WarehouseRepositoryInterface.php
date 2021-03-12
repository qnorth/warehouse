<?php

namespace App\Core\Domain\Repository;

use App\Core\Domain\Warehouse;

interface WarehouseRepositoryInterface
{
    /**
     * @param Warehouse $warehouse
     * @return void
     */
    public function save(Warehouse $warehouse): void;

    /**
     * @return Warehouse[]
     */
    public function findAll(): array;
}
