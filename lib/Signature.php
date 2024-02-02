<?php

namespace PayPro;

class Signature
{
    // Default timestamp tolerance is 10 minutes
    public const DEFAULT_TOLERANCE = 600;

    /** @var string payload of the webhook */
    private $payload;

    /** @var int epoch timestamp */
    private $timestamp;

    /** @var string secret of the webhook */
    private $secret;

    /** @var int tolerance of the timestamp in seconds */
    private $tolerance;

    /**
     * Creates an instance of the Signature class which can be used to verify webhook signatures.
     *
     * @param string $payload the payload of the webhook event
     * @param int $timestamp the timestamp in the header
     * @param string $secret the secret of the webhook used to generate the signature
     * @param int $tolerance the tolerance allowed between the current time and the timestamp in the header
     *
     * @return Signature the instance of Signature
     *
     * @throws Exception\InvalidArgumentException when a parameters has the incorrect format
     */
    public function __construct($payload, $timestamp, $secret, $tolerance = self::DEFAULT_TOLERANCE)
    {
        if (!\is_string($payload)) {
            throw new Exception\InvalidArgumentException('payload must be a string');
        }

        if (!\is_int($timestamp)) {
            throw new Exception\InvalidArgumentException('timestamp must be an epoch integer');
        }

        if (!\is_string($secret)) {
            throw new Exception\InvalidArgumentException('secret must be a string');
        }

        if (!\is_int($tolerance)) {
            throw new Exception\InvalidArgumentException('tolerance must be an integer');
        }

        $this->payload = $payload;
        $this->timestamp = $timestamp;
        $this->secret = $secret;
        $this->tolerance = $tolerance;
    }

    /**
     * Generates the signature based on the values provided in the Signature instance.
     */
    public function generateSignature()
    {
        return hash_hmac('sha256', $this->signatureString(), $this->secret);
    }

    /**
     * Verifies if the given signature is the same as the signature generated by this instance.
     * When the tolerance is passed or the signature is not correct it will throw an
     * Exception\SignatureVerificationException. If the supplied signature is not valid it will throw
     * an Exception\InvalidArgumentException.
     *
     * @param string $signature
     *
     * @return bool
     *
     * @throws Exception\InvalidArgumentException when the signature has an invalid format
     * @throws Exception\SignatureVerificationException when the signature cannot be verified
     */
    public function verify($signature)
    {
        if (!\is_string($signature)) {
            throw new Exception\InvalidArgumentException('signature must be a string');
        }

        if (!hash_equals($this->generateSignature(), $signature)) {
            $message = 'Signature does not match';

            throw Exception\SignatureVerificationException::create($message, null, $this->payload);
        }

        if (abs(time() - $this->timestamp) > $this->tolerance) {
            $message = 'Timestamp is outside the tolerance zone';

            throw Exception\SignatureVerificationException::create($message, null, $this->payload);
        }

        return true;
    }

    /**
     * Returns the signature string in the correct format.
     *
     * @return string
     */
    private function signatureString()
    {
        return $this->timestamp . '.' . $this->payload;
    }
}
