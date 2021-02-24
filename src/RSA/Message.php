<?php

namespace Ypho\RSA;

use Ypho\Exceptions\KeyException;

class Message
{
    /**
     * Private key (d, N)
     * @var array
     */
    private array $privateKey;

    /**
     * Public key (e, N)
     * @var array
     */
    private array $publicKey;

    /**
     * Sets the private key that can be used for decrypting messages
     * @param array $privateKey
     * @throws KeyException
     */
    public function setPrivateKey(array $privateKey): void
    {
        if(!isset($privateKey['d']) || !isset($privateKey['N'])) {
            throw new KeyException('Private key should contain d and N.');
        }

        $this->privateKey = $privateKey;
    }

    /**
     * Sets the public key that can be used for encrypting message
     * @param array $publicKey
     * @throws KeyException
     */
    public function setPublicKey(array $publicKey): void
    {
        if(!isset($publicKey['e']) || !isset($publicKey['N'])) {
            throw new KeyException('Public key should contain e and N.');
        }

        $this->publicKey = $publicKey;
    }

    /**
     * Encrypts each character of a message with formula: M ^ e mod(N)
     * @param string $messageToEncrypt
     * @return int[]
     * @throws KeyException
     */
    public function encrypt(string $messageToEncrypt): array
    {
        if (!isset($this->publicKey) || !isset($this->publicKey['e']) || !isset($this->publicKey['N'])) {
            throw new KeyException('No valid public key available!');
        }

        $e = $this->publicKey['e'];
        $n = $this->publicKey['N'];

        $encryptedMessage = [];
        for ($i = 0; $i < strlen($messageToEncrypt); $i++) {
            // Convert character to decimal value
            $decimalValue = ord($messageToEncrypt[$i]);

            $pow = bcpow($decimalValue, $e);
            $mod = bcmod($pow, $n);

            // Add encrypted character to array
            $encryptedMessage[] = $mod;
        }

        return $encryptedMessage;
    }

    /**
     * Decrypts each character of encrypted message with formula: Me ^ d mod(N)
     * @param array $encryptedCharacters
     * @return string
     * @throws KeyException
     */
    public function decrypt(array $encryptedCharacters): string
    {
        if (!isset($this->privateKey) || !isset($this->privateKey['d']) || !isset($this->privateKey['N'])) {
            throw new KeyException('No valid private key available!');
        }

        $d = $this->privateKey['d'];
        $n = $this->privateKey['N'];

        $decryptedMessage = '';
        foreach ($encryptedCharacters as $character) {
            $decimalValue = bcmod(bcpow($character, $d), $n);

            // Convert from decimal to character
            $decryptedMessage .= chr($decimalValue);
        }

        return $decryptedMessage;
    }
}
