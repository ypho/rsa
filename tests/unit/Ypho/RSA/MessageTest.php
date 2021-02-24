<?php

namespace Tests\Unit\Ypho\RSA;

use PHPUnit\Framework\TestCase;
use Ypho\Exceptions\KeyException;
use Ypho\RSA\KeyPair;
use Ypho\RSA\Message;

class MessageTest extends TestCase
{
    public function test_setValidPrivateKey()
    {
        $this->expectNotToPerformAssertions();

        $msg = new Message();
        $msg->setPrivateKey(['d' => 267, 'N' => 377]);
    }

    public function test_setValidPublicKey()
    {
        $this->expectNotToPerformAssertions();

        $msg = new Message();
        $msg->setPublicKey(['e' => 5, 'N' => 377]);
    }

    public function test_setInvalidPrivateKey()
    {
        $this->expectException(KeyException::class);
        $this->expectExceptionMessage('Private key should contain d and N.');

        $msg = new Message();
        $msg->setPrivateKey(['e' => 5, 'N' => 377]);
    }

    public function test_setInvalidPublicKey()
    {
        $this->expectException(KeyException::class);
        $this->expectExceptionMessage('Public key should contain e and N.');

        $msg = new Message();
        $msg->setPublicKey(['d' => 267, 'N' => 377]);
    }

    /**
     * @param int $p
     * @param int $q
     * @param string $message
     * @param array $encryptedMessage
     * @throws KeyException
     * @throws \Ypho\Exceptions\GenerateKeypairException
     * @dataProvider encryptionProvider
     */
    public function test_encrypt(int $p, int $q, string $message, array $encryptedMessage)
    {
        $kp = new KeyPair($p, $q);

        $msg = new Message();
        $msg->setPublicKey($kp->getPublicKey());

        $encryptionResult = $msg->encrypt($message);
        $this->assertEquals($encryptedMessage, $encryptionResult);
    }

    public function test_encryptWithoutPublicKey()
    {
        $this->expectException(KeyException::class);
        $this->expectExceptionMessage('No valid public key available!');

        $msg = new Message();
        $msg->encrypt('Hello World!');
    }

    public function test_decryptWithoutPrivateKey()
    {
        $this->expectException(KeyException::class);
        $this->expectExceptionMessage('No valid private key available!');

        $msg = new Message();
        $msg->decrypt([193, 251, 205, 205, 297, 301, 29, 297, 316, 205, 354, 154]);
    }

    /**
     * @param int $p
     * @param int $q
     * @param string $message
     * @param array $encryptedMessage
     * @throws KeyException
     * @throws \Ypho\Exceptions\GenerateKeypairException
     * @dataProvider encryptionProvider
     */
    public function test_decrypt(int $p, int $q, string $message, array $encryptedMessage)
    {
        $kp = new KeyPair($p, $q);

        $msg = new Message();
        $msg->setPrivateKey($kp->getPrivateKey());

        $decryptionResult = $msg->decrypt($encryptedMessage);
        $this->assertEquals($message, $decryptionResult);
    }

    /**
     * @return array[]
     */
    public function encryptionProvider(): array
    {
        return [
            [29, 13, 'Hello World!', [193, 251, 205, 205, 297, 301, 29, 297, 316, 205, 354, 154]],
            [17, 41, 'Hello World!', [353, 135, 233, 233, 117, 9, 535, 117, 419, 233, 502, 390]],

        ];
    }
}