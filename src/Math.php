<?php

namespace Ypho;

class Math
{
    /**
     * Determine if given number is prime
     * @param int $number
     * @return bool
     */
    static function isPrime(int $number): bool
    {
        for ($i = 2; $i < $number; $i ++) {
            if ($number % $i == 0) {
                return false;
            }
        }

        return true;
    }

    /**
     * If two numbers don't share any factors, they are relative prime (coprime)
     * @param int $num1
     * @param int $num2
     * @return bool
     */
    static function areCoprime(int $num1, int $num2): bool
    {
        // If both numbers is prime, they are coprime
        if (self::isPrime($num1) && self::isPrime($num2)) {
            return true;
        }

        // Create an array of all factors
        $factorsNum1 = self::factors($num1);
        $factorsNum2 = self::factors($num2);

        $arrFactors = array_merge($factorsNum1, $factorsNum2);
        $totalFactors = count($arrFactors);
        $totalUniqueFactors = count(array_unique($arrFactors));

        return $totalFactors === $totalUniqueFactors;
    }

    /**
     * Finds all factors of a given number
     * @param int $num
     * @return array
     */
    static function factors(int $num): array
    {
        $arrFactors = [];

        for ($i = 1; $i <= sqrt(abs($num)); $i ++) {
            // If the division gives no modulus, add both of them to the array
            if ($num % $i == 0) {
                $z = $num / $i;

                array_push($arrFactors, $i, $z);
            }
        }

        // Remove instances of 1 from the array
        if (($key = array_search(1, $arrFactors)) !== false) {
            unset($arrFactors[$key]);
        }

        // Remove duplicate values
        $arrFactors = array_unique($arrFactors);

        // Sort from low to high
        sort($arrFactors);

        return array_values($arrFactors);
    }
}
