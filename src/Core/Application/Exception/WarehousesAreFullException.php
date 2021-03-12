<?php

namespace App\Core\Application\Exception;

use Throwable;

class WarehousesAreFullException extends ApplicationException
{
    public function __construct(Throwable $previous = null)
    {
        parent::__construct('The warehouses are full of items', 400, $previous);
    }
}
