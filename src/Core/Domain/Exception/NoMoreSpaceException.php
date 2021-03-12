<?php

namespace App\Core\Domain\Exception;

use Throwable;
use function sprintf;

class NoMoreSpaceException extends DomainException
{
    public function __construct(int $capacity, Throwable $previous = null)
    {
        parent::__construct(sprintf('There is not enough space (capacity: %d)', $capacity), 400, $previous);
    }
}
