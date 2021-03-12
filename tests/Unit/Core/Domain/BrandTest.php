<?php

namespace App\Tests\Unit\Core\Domain;

use App\Core\Domain\Brand;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class BrandTest extends TestCase
{
    /**
     * @test
     * @dataProvider dataProvider
     */
    public function constructor_with_quality_category(bool $expectException, int $qualityCategory): void
    {
        if ($expectException) {
            $this->expectException(InvalidArgumentException::class);
        } else {
            $this->expectNotToPerformAssertions();
        }

        $subject = new Brand('Test', $qualityCategory);
    }

    public function dataProvider(): array
    {
        return [
            [true, -1],
            [true, 0],
            [false, 1],
            [false, 2],
            [false, 3],
            [false, 4],
            [false, 5],
            [true, 6],
            [true, 99],
        ];
    }
}
