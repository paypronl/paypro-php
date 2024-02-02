<?php

namespace PayPro\Endpoints;

use PayPro\Entities\Collection;
use PayPro\Entities\SubscriptionPeriod;
use PayPro\TestCase;
use PayPro\TestHelper;

final class SubscriptionPeriodsTest extends TestCase
{
    use TestHelper;

    public function testIsListable()
    {
        $response = $this->getFixture('subscription_periods/list.json');

        $this->stubRequest(
            'get',
            '/subscription_periods',
            null,
            null,
            null,
            $response
        );

        $endpoint = new SubscriptionPeriods($this->apiClient);
        $list = $endpoint->list();

        $this->assertInstanceOf(Collection::class, $list);
        $this->assertInstanceOf(SubscriptionPeriod::class, $list->first());
    }

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

        $this->assertInstanceOf(SubscriptionPeriod::class, $subscription_period);
        $this->assertSame($subscription_period->id, 'SPCMTC4RJLPNWT');
        $this->assertSame($subscription_period->period_number, 1);
        $this->assertSame($subscription_period->amount, 5000);
    }
}
