<?php

namespace PayPro;

use PayPro\Endpoints\Chargebacks;
use PayPro\Endpoints\Customers;
use PayPro\Endpoints\Events;
use PayPro\Endpoints\InstallmentPlanPeriods;
use PayPro\Endpoints\InstallmentPlans;
use PayPro\Endpoints\Mandates;
use PayPro\Endpoints\Payments;
use PayPro\Endpoints\PayMethods;
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

        self::assertInstanceOf(Chargebacks::class, $client->chargebacks);
        self::assertInstanceOf(Customers::class, $client->customers);
        self::assertInstanceOf(Events::class, $client->events);
        self::assertInstanceOf(InstallmentPlanPeriods::class, $client->installmentPlanPeriods);
        self::assertInstanceOf(InstallmentPlans::class, $client->installmentPlans);
        self::assertInstanceOf(Mandates::class, $client->mandates);
        self::assertInstanceOf(Payments::class, $client->payments);
        self::assertInstanceOf(PayMethods::class, $client->payMethods);
        self::assertInstanceOf(Refunds::class, $client->refunds);
        self::assertInstanceOf(SubscriptionPeriods::class, $client->subscriptionPeriods);
        self::assertInstanceOf(Subscriptions::class, $client->subscriptions);
        self::assertInstanceOf(Webhooks::class, $client->webhooks);
    }
}
