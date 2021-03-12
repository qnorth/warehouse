<?php

namespace App\Core\Domain;

use App\Core\Domain\Exception\NoMoreSpaceException;
use function count;

class Warehouse
{
    private string $name;
    private string $address;
    private int $capacity;

    /**
     * @var AbstractProduct[]
     */
    private array $stock;

    /**
     * Warehouse constructor.
     * @param string $name
     * @param string $address
     * @param int $capacity
     * @param AbstractProduct[] $stock
     */
    public function __construct(
        string $name,
        string $address,
        int $capacity,
        array $stock = []
    ) {
        $this->name = $name;
        $this->address = $address;
        $this->capacity = $capacity;
        $this->stock = $stock;
    }

    /**
     * @return AbstractProduct[]
     */
    public function getStock(): array
    {
        return $this->stock;
    }

    /**
     * @param AbstractProduct $product
     * @return void
     * @throws NoMoreSpaceException
     */
    public function addItem(AbstractProduct $product): void
    {
        $counter = count($this->stock);

        if ($counter >= $this->capacity) {
            throw new NoMoreSpaceException($this->capacity);
        }

        $this->stock[] = $product;
    }

    /**
     * @param string $sku
     * @return AbstractProduct|null
     */
    public function getItemBySku(string $sku): ?AbstractProduct
    {
        foreach ($this->stock as $item) {
            if ($sku === $item->getSku()) {
                return $item;
            }
        }

        return null;
    }

    /**
     * @param string $sku
     * @return bool
     */
    public function removeItemBySku(string $sku): bool
    {
        foreach ($this->stock as $key => $item) {
            if ($sku === $item->getSku()) {
                unset($this->stock[$key]);

                return true;
            }
        }

        return false;
    }
}
