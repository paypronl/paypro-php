<?php

namespace PayPro;

final class ClientTest extends \PayPro\TestCase
{
    use \PayPro\TestHelper;

    public function testConstructorWithInvalidConfig()
    {
        $config = 1;

        $this->expectException(\PayPro\Exception\InvalidArgumentException::class);
        $this->expectExceptionMessage('$config must be a string or array');

        $client = new \PayPro\Client($config);
    }

    public function testConstructorWithNonStringApiKey()
    {
        $config = ['api_key' => 1];

        $this->expectException(\PayPro\Exception\InvalidArgumentException::class);
        $this->expectExceptionMessage('api_key must be null or a string');

        $client = new \PayPro\Client($config);
    }

    public function testConstructorWithEmptyApiKey()
    {
        $config = '';

        $this->expectException(\PayPro\Exception\InvalidArgumentException::class);
        $this->expectExceptionMessage('api_key cannot be an empty string');

        $client = new \PayPro\Client($config);
    }

    public function testConstructorWithWhitespacesInApiKey()
    {
        $config = ['api_key' => 'api key '];

        $this->expectException(\PayPro\Exception\InvalidArgumentException::class);
        $this->expectExceptionMessage('api_key cannot contain whitespaces');

        $client = new \PayPro\Client($config);
    }

    public function testHasEndpointsSetup()
    {
        $client = new \PayPro\Client('api_key');

        $this->assertInstanceOf(\PayPro\Endpoints\Chargebacks::class, $client->chargebacks);
        $this->assertInstanceOf(\PayPro\Endpoints\Customers::class, $client->customers);
        $this->assertInstanceOf(\PayPro\Endpoints\Events::class, $client->events);
        $this->assertInstanceOf(\PayPro\Endpoints\Payments::class, $client->payments);
        $this->assertInstanceOf(\PayPro\Endpoints\Refunds::class, $client->refunds);
        $this->assertInstanceOf(\PayPro\Endpoints\SubscriptionPeriods::class, $client->subscriptionPeriods);
        $this->assertInstanceOf(\PayPro\Endpoints\Subscriptions::class, $client->subscriptions);
        $this->assertInstanceOf(\PayPro\Endpoints\Webhooks::class, $client->webhooks);
    }
}
