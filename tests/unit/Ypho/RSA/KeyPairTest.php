<?php

namespace Tests\Unit\Ypho\RSA;

use PHPUnit\Framework\TestCase;
use Ypho\Exceptions\GenerateKeypairException;
use Ypho\RSA\KeyPair;

class KeyPairTest extends TestCase
{
    /**
     * @param int $p
     * @param int $q
     * @param array $pubKey
     * @param array $privateKey
     * @throws \Ypho\Exceptions\GenerateKeypairException
     * @throws \Ypho\Exceptions\KeyException
     * @dataProvider validKeyPairProvider
     */
    public function test_KeyPairSuccessful(int $p, int $q, array $pubKey, array $privateKey)
    {
        $kp = new KeyPair($p, $q);
        $this->assertEquals($pubKey, $kp->getPublicKey());
        $this->assertEquals($privateKey, $kp->getPrivateKey());
    }

    /**
     * @param int $p
     * @param int $q
     * @param string $exceptionObject
     * @param string $exceptionMessage
     * @throws GenerateKeypairException
     * @dataProvider invalidKeyPairProvider
     */
    public function test_KeyPairExceptions(int $p, int $q, string $exceptionObject, string $exceptionMessage)
    {
        $this->expectException($exceptionObject);
        $this->expectExceptionMessage($exceptionMessage);

        new KeyPair($p, $q);
    }

    /**
     * @param int $p
     * @param int $q
     * @param array $pubKey
     * @param array $privateKey
     * @dataProvider validKeyPairProvider
     */
    public function test_getKeyPair(int $p, int $q, array $pubKey, array $privateKey)
    {
        $kp = new KeyPair($p, $q);
        $keyPair = $kp->getKeyPair();

        $this->assertEquals($keyPair['public'], $pubKey);
        $this->assertEquals($keyPair['private'], $privateKey);
    }

    /**
     * @return array[]
     */
    public function validKeyPairProvider(): array
    {
        return [
            [11, 17, ['e' => 3, 'N' => 187], ['d' => 107, 'N' => 187]],
            [29, 13, ['e' => 5, 'N' => 377], ['d' => 269, 'N' => 377]],
        ];
    }

    /**
     * @return array[]
     */
    public function invalidKeyPairProvider(): array
    {
        return [
            [4, 17, GenerateKeypairException::class, 'Both p and q should be prime numbers.'],
            [41, 8, GenerateKeypairException::class, 'Both p and q should be prime numbers.'],
            [17, 17, GenerateKeypairException::class, 'Both p and q should be different numbers.'],
            [-7, 71, GenerateKeypairException::class, 'Both p and q should be numbers between 10 and 100.'],
            [23, -5, GenerateKeypairException::class, 'Both p and q should be numbers between 10 and 100.'],
            [131, 17, GenerateKeypairException::class, 'Both p and q should be numbers between 10 and 100.'],
            [23, 199, GenerateKeypairException::class, 'Both p and q should be numbers between 10 and 100.'],
            [7, 11, GenerateKeypairException::class, 'Both p and q should be numbers between 10 and 100.'],
            [13, 5, GenerateKeypairException::class, 'Both p and q should be numbers between 10 and 100.'],
        ];
    }
}