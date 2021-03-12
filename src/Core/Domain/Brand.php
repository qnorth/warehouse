<?php

namespace App\Core\Domain;

use InvalidArgumentException;

class Brand
{
    private string $name;
    private int $qualityCategory;

    /**
     * Brand constructor.
     * @param string $name
     * @param int $qualityCategory
     */
    public function __construct(
        string $name,
        int $qualityCategory
    ) {
        self::assertQualityCategory($qualityCategory);

        $this->name = $name;
        $this->qualityCategory = $qualityCategory;
    }

    private static function assertQualityCategory(int $qualityCategory): void
    {
        if ($qualityCategory < 1 || $qualityCategory > 5) {
            throw new InvalidArgumentException('The value of "qualityCategory" must be between 1 and 5');
        }
    }
}
