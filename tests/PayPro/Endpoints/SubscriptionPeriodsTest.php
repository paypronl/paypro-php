<?php

namespace PayPro\Endpoints;

final class SubscriptionPeriodsTest extends \PayPro\TestCase
{
    use \PayPro\TestHelper;

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

        $endpoint = new \PayPro\Endpoints\SubscriptionPeriods($this->apiClient);
        $list = $endpoint->list();

        $this->assertInstanceOf(\PayPro\Entities\Collection::class, $list);
        $this->assertInstanceOf(\PayPro\Entities\SubscriptionPeriod::class, $list->first());
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

        $endpoint = new \PayPro\Endpoints\SubscriptionPeriods($this->apiClient);
        $subscription_period = $endpoint->get('SPCMTC4RJLPNWT');

        $this->assertInstanceOf(\PayPro\Entities\SubscriptionPeriod::class, $subscription_period);
        $this->assertSame($subscription_period->id, 'SPCMTC4RJLPNWT');
        $this->assertSame($subscription_period->period_number, 1);
        $this->assertSame($subscription_period->amount, 5000);
    }
}
