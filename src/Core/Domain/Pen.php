<?php

namespace App\Core\Domain;

final class Pen extends AbstractProduct
{
    private string $color;

    /**
     * Pen constructor.
     * @param string $sku
     * @param string $name
     * @param float $price
     * @param Brand $brand
     * @param string $color
     */
    public function __construct(
        string $sku,
        string $name,
        float $price,
        Brand $brand,
        string $color
    ) {
        $this->sku = $sku;
        $this->name = $name;
        $this->price = $price;
        $this->brand = $brand;
        $this->color = $color;
    }
}
