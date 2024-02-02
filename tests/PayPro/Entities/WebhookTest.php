<?php

namespace PayPro\Entities;

use PayPro\Exception\InvalidEventPayloadException;
use PayPro\Exception\SignatureVerificationException;
use PayPro\TestCase;
use PayPro\TestHelper;

final class WebhookTest extends TestCase
{
    use TestHelper;

    public function testDelete()
    {
        $response = $this->getFixture('webhooks/get.json');
        $data = \json_decode($response, true);

        $this->stubRequest(
            'delete',
            '/webhooks/WH43CVU3A1TD6Z',
            null,
            null,
            null,
            $response
        );

        $webhook = new Webhook($data, $this->apiClient);

        $responseWebhook = $webhook->delete();
        $this->assertInstanceOf(Webhook::class, $responseWebhook);
    }

    public function testUpdate()
    {
        $response = $this->getFixture('webhooks/get.json');
        $data = \json_decode($response, true);

        $this->stubRequest(
            'patch',
            '/webhooks/WH43CVU3A1TD6Z',
            null,
            null,
            ['active' => false],
            $response
        );

        $webhook = new Webhook($data, $this->apiClient);

        $responseWebhook = $webhook->update(['active' => false]);
        $this->assertInstanceOf(Webhook::class, $responseWebhook);
    }

    public function testCreateEventWithInvalidSignature()
    {
        $payload = $this->getFixture('events/get.json');
        $secret = '996QF2kLfVcmF8hzikZVfeB7GPH2RdP7';
        $timestamp = 1702298964;
        $tolerance = 1000000000;
        $signature = 'secret';

        $this->expectException(SignatureVerificationException::class);
        $this->expectExceptionMessage('Signature does not match');

        Webhook::createEvent($payload, $signature, $secret, $timestamp, $tolerance);
    }

    public function testCreateEventWithInvalidPayload()
    {
        $payload = '';
        $secret = '996QF2kLfVcmF8hzikZVfeB7GPH2RdP7';
        $timestamp = 1702298964;
        $tolerance = 1000000000;
        $signature = 'd83474e81c7758cc82ff6a4bf60e592a64ff8f54d1de82115acb9d1d1ec4793d';

        $this->expectException(InvalidEventPayloadException::class);
        $this->expectExceptionMessage('Invalid payload  (json_last_error() was 4)');

        Webhook::createEvent($payload, $signature, $secret, $timestamp, $tolerance);
    }

    public function testCreateEventWithValidSignature()
    {
        $payload = $this->getFixture('events/get.json');

        $secret = '996QF2kLfVcmF8hzikZVfeB7GPH2RdP7';
        $timestamp = 1702298964;
        $tolerance = 1000000000;
        $signature = 'c3e62291042d23fb21c1a0881544125a667f0f9df90d81a91ca9ccc9e4b9f6ec';

        $event = Webhook::createEvent(
            $payload,
            $signature,
            $secret,
            $timestamp,
            $tolerance
        );

        $this->assertInstanceOf(Event::class, $event);
    }
}
