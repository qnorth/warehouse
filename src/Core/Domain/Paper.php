<?php

namespace App\Core\Domain;

final class Paper extends AbstractProduct
{
    private string $size;

    /**
     * Paper constructor.
     * @param string $sku
     * @param string $name
     * @param float $price
     * @param Brand $brand
     * @param string $size
     */
    public function __construct(
        string $sku,
        string $name,
        float $price,
        Brand $brand,
        string $size
    ) {
        $this->sku = $sku;
        $this->name = $name;
        $this->price = $price;
        $this->brand = $brand;
        $this->size = $size;
    }
}
