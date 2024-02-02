<?php

namespace PayPro;

use PayPro\Endpoints\Chargebacks;
use PayPro\Endpoints\Customers;
use PayPro\Endpoints\Events;
use PayPro\Endpoints\Payments;
use PayPro\Endpoints\Refunds;
use PayPro\Endpoints\SubscriptionPeriods;
use PayPro\Endpoints\Subscriptions;
use PayPro\Endpoints\Webhooks;
use PayPro\Exception\InvalidArgumentException;

final class ClientTest extends TestCase
{
    use TestHelper;

    public function testConstructorWithInvalidConfig()
    {
        $config = 1;

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('$config must be a string or array');

        $client = new Client($config);
    }

    public function testConstructorWithNonStringApiKey()
    {
        $config = ['api_key' => 1];

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('api_key must be null or a string');

        $client = new Client($config);
    }

    public function testConstructorWithEmptyApiKey()
    {
        $config = '';

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('api_key cannot be an empty string');

        $client = new Client($config);
    }

    public function testConstructorWithWhitespacesInApiKey()
    {
        $config = ['api_key' => 'api key '];

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('api_key cannot contain whitespaces');

        $client = new Client($config);
    }

    public function testHasEndpointsSetup()
    {
        $client = new Client('api_key');

        $this->assertInstanceOf(Chargebacks::class, $client->chargebacks);
        $this->assertInstanceOf(Customers::class, $client->customers);
        $this->assertInstanceOf(Events::class, $client->events);
        $this->assertInstanceOf(Payments::class, $client->payments);
        $this->assertInstanceOf(Refunds::class, $client->refunds);
        $this->assertInstanceOf(SubscriptionPeriods::class, $client->subscriptionPeriods);
        $this->assertInstanceOf(Subscriptions::class, $client->subscriptions);
        $this->assertInstanceOf(Webhooks::class, $client->webhooks);
    }
}
