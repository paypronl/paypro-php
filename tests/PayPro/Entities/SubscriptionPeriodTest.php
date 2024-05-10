<?php

namespace PayPro\Entities;

use PayPro\TestCase;
use PayPro\TestHelper;

final class SubscriptionPeriodTest extends TestCase
{
    use TestHelper;

    public function testPayments()
    {
        $response = $this->getFixture('subscription_periods/payments.json');
        $data = json_decode($this->getFixture('subscription_periods/get.json'), true);

        $this->stubRequest(
            'get',
            '/subscription_periods/SPCMTC4RJLPNWT/payments',
            null,
            null,
            null,
            $response
        );

        $subscriptionPeriod = new SubscriptionPeriod($data, $this->apiClient);

        $payments = $subscriptionPeriod->payments();
        self::assertInstanceOf(Collection::class, $payments);
        self::assertInstanceOf(Payment::class, $payments->first());
    }
}
