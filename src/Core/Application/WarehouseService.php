<?php

namespace App\Core\Application;

use App\Core\Application\Exception\WarehousesAreFullException;
use App\Core\Domain\AbstractProduct;
use App\Core\Domain\Exception\NoMoreSpaceException;
use App\Core\Domain\Warehouse;
use App\Core\Domain\Repository\WarehouseRepositoryInterface;
use function array_merge;

class WarehouseService
{
    /**
     * @var WarehouseRepositoryInterface
     */
    private WarehouseRepositoryInterface $warehouseRepository;

    /**
     * WarehouseService constructor.
     * @param WarehouseRepositoryInterface $warehouseRepository
     */
    public function __construct(
        WarehouseRepositoryInterface $warehouseRepository
    ) {
        $this->warehouseRepository = $warehouseRepository;
    }

    /**
     * Létrehoz egy új raktárat
     *
     * @param array $data
     * @return void
     */
    public function createNew(array $data): void
    {
        $warehouse = new Warehouse(
            $data['name'],
            $data['address'],
            $data['capacity'],
            $data['stock'] ?? [],
        );

        $this->warehouseRepository->save($warehouse);
    }

    /**
     * Visszaadja a raktárak tartalmát
     *
     * @return array
     */
    public function getAllContent(): array
    {
        $contents = [];
        $warehouses = $this->warehouseRepository->findAll();

        foreach ($warehouses as $warehouse) {
            $contents = array_merge($contents, $warehouse->getStock());
        }

        return $contents;
    }

    /**
     * Kikér valamennyi tételt valamely raktárból
     *
     * @param string[] $skus
     * @return AbstractProduct[]
     */
    public function getProducts(array $skus): array
    {
        $result = [];

        if (empty($skus)) {
            return $result;
        }

        $warehouses = $this->warehouseRepository->findAll();

        foreach ($warehouses as $warehouse) {
            foreach ($skus as $key => $sku) {
                $item = $warehouse->getItemBySku($sku);

                if ($item === null) {
                    continue;
                }

                $result[] = $item;

                unset($skus[$key]);
            }
        }

        return $result;
    }

    /**
     * @param string[] $skus
     * @return void
     */
    public function removeProducts(array $skus): void
    {
        if (empty($skus)) {
            return;
        }

        $warehouses = $this->warehouseRepository->findAll();

        foreach ($warehouses as $warehouse) {
            foreach ($skus as $key => $sku) {
                $result = $warehouse->removeItemBySku($sku);

                if ($result === true) {
                    unset($skus[$key]);

                    break;
                }
            }
        }
    }

    /**
     * Hozzáad valamennyi tételt valamely raktárba
     *
     * @param AbstractProduct[] $products
     * @return void
     * @throws WarehousesAreFullException
     */
    public function addProducts(array $products): void
    {
        $current = 0;
        $warehouses = $this->warehouseRepository->findAll();

        foreach ($products as $product) {
            $this->addProduct($warehouses, $current, $product);
        }
    }

    /**
     * @param Warehouse[] $warehouses
     * @param int $current
     * @param AbstractProduct $product
     * @return void
     * @throws WarehousesAreFullException
     */
    private function addProduct(array $warehouses, int $current, AbstractProduct $product): void
    {
        try {
            $warehouses[$current]->addItem($product);
        } catch (NoMoreSpaceException $exception) {
            $current++;

            if (!isset($warehouses[$current])) {
                throw new WarehousesAreFullException();
            }

            $this->addProduct($warehouses, $current, $product);
        }
    }
}
