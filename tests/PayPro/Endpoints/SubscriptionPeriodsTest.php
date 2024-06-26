<?php

namespace PayPro\Endpoints;

use PayPro\Entities\SubscriptionPeriod;
use PayPro\TestCase;
use PayPro\TestHelper;

final class SubscriptionPeriodsTest extends TestCase
{
    use TestHelper;

    public function testIsGettable()
    {
        $response = $this->getFixture('subscription_periods/get.json');

        $this->stubRequest(
            'get',
            '/subscription_periods/SPCMTC4RJLPNWT',
            null,
            null,
            null,
            $response
        );

        $endpoint = new SubscriptionPeriods($this->apiClient);
        $subscription_period = $endpoint->get('SPCMTC4RJLPNWT');

        self::assertInstanceOf(SubscriptionPeriod::class, $subscription_period);
        self::assertSame($subscription_period->id, 'SPCMTC4RJLPNWT');
        self::assertSame($subscription_period->period_number, 1);
        self::assertSame($subscription_period->amount, 5000);
    }
}
