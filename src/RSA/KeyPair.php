<?php

namespace Ypho\RSA;

use Ypho\Exceptions\GenerateKeypairException;
use Ypho\Exceptions\KeyException;
use Ypho\Math;

class KeyPair
{
    /**
     * Factor p
     * @var int
     */
    private int $p;

    /**
     * Factor q
     * @var int
     */
    private int $q;

    /**
     * Modulus N
     * @var int
     */
    private int $n;

    /**
     * Phi of N
     * @var int
     */
    private int $phiN;

    /**
     * Public factor e, for encryption (public key)
     * @var int
     */
    private int $e;

    /**
     * Private factor d, for decryption (private key)
     * @var int
     */
    private int $d;

    /**
     * Keypair constructor.
     * @param int $p
     * @param int $q
     * @throws GenerateKeypairException
     */
    public function __construct(int $p, int $q)
    {
        if (!Math::isPrime($p) || !Math::isPrime($q)) {
            throw new GenerateKeypairException('Both p and q should be prime numbers.');
        }

        if ($p === $q) {
            throw new GenerateKeypairException('Both p and q should be different numbers.');
        }

        if (($p < 10 || $q < 10) || ($p > 100 || $q > 100)) {
            throw new GenerateKeypairException('Both p and q should be numbers between 10 and 100.');
        }

        // Set the factors
        $this->p = $p;
        $this->q = $q;

        // Calculate some factors
        $this->calculateN();
        $this->calculatePhiN();

        // Calculate key parts
        $this->calculateE();
        $this->calculateD();
    }

    /**
     * Calculates N = p*q
     */
    private function calculateN(): void
    {
        $this->n = $this->p * $this->q;
    }

    /**
     * Calculates phi(N) = (p-1) * (q-1)
     */
    private function calculatePhiN(): void
    {
        $this->phiN = ($this->p - 1) * ($this->q - 1);
    }

    /**
     * Calculates e, must abide by:
     * - 1 < e < phi(N)
     * - Coprime with N and phi(N)
     */
    private function calculateE(): void
    {
        for ($e = 2; $e < $this->phiN; $e ++) {
            $coprimeWithN = Math::areCoprime($e, $this->n);
            $coprimeWithPhiN = Math::areCoprime($e, $this->phiN);

            if ($coprimeWithN && $coprimeWithPhiN) {
                $this->e = $e;
                return;
            }
        }

        throw new GenerateKeypairException('There are no coprimes found, therefore e can\'t be calculated.');
    }

    /**
     * Calculates d, using formula:
     * d * e(mod(phiN)) = 1
     *
     * Not necessary, but for clarification purposes we skip $d if $d === $e
     */
    private function calculateD()
    {
        for ($d = 1; $d < 10000; $d ++) {
            if (($d * $this->e) % $this->phiN === 1 && $d !== $this->e) {
                $this->d = $d;
                return;
            }
        }

        throw new GenerateKeypairException('We can\'t calculate d. Try smaller numbers for p and q.');
    }

    /**
     * Return the keypair
     * @return array
     * @throws KeyException
     */
    public function getKeyPair(): array
    {
        return [
            'private' => $this->getPrivateKey(),
            'public' => $this->getPublicKey(),
        ];
    }

    /**
     * Returns the public key that can be used for encryption
     * @return array
     * @throws KeyException
     */
    public function getPublicKey(): array
    {
        if(!isset($this->e) || !isset($this->n)) {
            throw new KeyException('There is no public key available!');
        }

        return [
            'e' => $this->e,
            'N' => $this->n
        ];
    }

    /**
     * Returns the private key that can be used for decryption
     * @return array
     * @throws KeyException
     */
    public function getPrivateKey(): array
    {
        if(!isset($this->d) || !isset($this->n)) {
            throw new KeyException('There is no private key available!');
        }

        return [
            'd' => $this->d,
            'N' => $this->n
        ];
    }
}
