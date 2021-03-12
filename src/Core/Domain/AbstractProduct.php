<?php

namespace App\Core\Domain;

abstract class AbstractProduct
{
    protected string $sku;
    protected string $name;
    protected float $price;
    protected Brand $brand;

    /**
     * @return string
     */
    public function getSku(): string
    {
        return $this->sku;
    }
}
