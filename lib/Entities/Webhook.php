<?php

namespace PayPro\Entities;

use PayPro\Exception\InvalidEventPayloadException;
use PayPro\Exception\SignatureVerificationException;
use PayPro\Operations\Delete;
use PayPro\Operations\Request;
use PayPro\Operations\Update;
use PayPro\Signature;

class Webhook extends Resource
{
    use Delete;
    use Request;
    use Update;

    public function resourcePath()
    {
        return 'webhooks';
    }

    /**
     * Returns an Event instance using the JSON payload received from PayPro webhook events.
     * Throws an Exception\InvalidEventPayloadException when invalid payload is received or
     * an Exception\SignatureVerificationException when the signature is invalid.
     *
     * @param string $payload the payload of the webhook event
     * @param string $signature the signature from the signature header
     * @param string $secret the secret of the webhook used to generate the signature
     * @param int $timestamp the timestamp from the timestamp header
     * @param int $tolerance the tolerance allowed of the timestamp defaults to 600 seconds
     *
     * @return Event the Event instance
     *
     * @throws InvalidEventPayloadException if the payload is not valid JSON
     * @throws SignatureVerificationException if the signature verification fails
     */
    public static function createEvent(
        $payload,
        $signature,
        $secret,
        $timestamp,
        $tolerance = Signature::DEFAULT_TOLERANCE
    ) {
        $signatureVerifier = new Signature(
            $payload,
            $timestamp,
            $secret,
            $tolerance
        );

        $signatureVerifier->verify($signature);

        $data = json_decode($payload, true);
        $jsonError = json_last_error();

        if (null === $data && JSON_ERROR_NONE !== $jsonError) {
            $message = "Invalid payload {$payload} (json_last_error() was {$jsonError})";

            throw new InvalidEventPayloadException($message);
        }

        return new Event($data);
    }
}
