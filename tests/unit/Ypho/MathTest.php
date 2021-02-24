<?php

namespace Tests\Unit\Ypho;

use PHPUnit\Framework\TestCase;
use Ypho\Math;

class MathTest extends TestCase
{
    /**
     * @param int $number
     * @param bool $isPrime
     * @dataProvider primeProvider
     */
    public function test_isPrime(int $number, bool $isPrime)
    {
        $result = Math::isPrime($number);
        $this->assertEquals($isPrime, $result);
    }

    /**
     * @param int $number1
     * @param int $number2
     * @param bool $areCoprime
     * @dataProvider coprimeProvider
     */
    public function test_areCoprime(int $number1, int $number2, bool $areCoprime)
    {
        $result = Math::areCoprime($number1, $number2);
        $this->assertEquals($areCoprime, $result);
    }

    /**
     * @param int $number
     * @param array $factors
     * @dataProvider factorProvider
     */
    public function test_factors(int $number, array $factors)
    {
        $result = Math::factors($number);
        $this->assertEquals($factors, $result);
    }

    /**
     * @return array[]
     */
    public function primeProvider(): array
    {
        return [
            [2, true],
            [3, true],
            [4, false],
            [5, true],
            [6, false],
            [7, true],
            [8, false],
            [9, false],
            [10, false],
            [11, true],
            [13, true],
            [19, true],
            [21, false],
            [27, false],
            [31, true],
            [35, false],
        ];
    }

    /**
     * @return array[]
     */
    public function coprimeProvider(): array
    {
        return [
            [2, 3, true],
            [7, 11, true],
            [4, 20, false],
            [7, 63, false],
            [7, 64, true],
            [9, 90, false],
            [9, 17, true],
        ];
    }

    /**
     * @return array
     */
    public function factorProvider(): array
    {
        return [
            [1, [1]],
            [6, [2, 3, 6]],
            [7, [7]],
            [9, [3, 9]],
            [21, [3, 7, 21]],
            [23, [23]],
            [20, [2, 4, 5, 10, 20]],
            [21, [3, 7, 21]],
            [30, [2, 3, 5, 6, 10, 15, 30]],
            [47, [47]],
        ];
    }
}