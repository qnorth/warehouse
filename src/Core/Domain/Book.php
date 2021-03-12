<?php

namespace App\Core\Domain;

final class Book extends AbstractProduct
{
    private string $genre;

    /**
     * Book constructor.
     * @param string $sku
     * @param string $name
     * @param float $price
     * @param Brand $brand
     * @param string $genre
     */
    public function __construct(
        string $sku,
        string $name,
        float $price,
        Brand $brand,
        string $genre
    ) {
        $this->sku = $sku;
        $this->name = $name;
        $this->price = $price;
        $this->brand = $brand;
        $this->genre = $genre;
    }
}
