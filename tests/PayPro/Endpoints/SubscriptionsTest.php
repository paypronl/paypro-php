<?php

namespace PayPro\Endpoints;

final class SubscriptionsTest extends \PayPro\TestCase
{
    use \PayPro\TestHelper;

    public function testIsListable()
    {
        $response = $this->getFixture('subscriptions/list.json');

        $this->stubRequest(
            'get',
            '/subscriptions',
            null,
            null,
            null,
            $response
        );

        $endpoint = new \PayPro\Endpoints\Subscriptions($this->apiClient);
        $list = $endpoint->list();

        $this->assertInstanceOf(\PayPro\Entities\Collection::class, $list);
        $this->assertInstanceOf(\PayPro\Entities\Subscription::class, $list->first());
    }

    public function testIsGettable()
    {
        $response = $this->getFixture('subscriptions/get.json');

        $this->stubRequest(
            'get',
            '/subscriptions/PS8PTGUPZTSLBP',
            null,
            null,
            null,
            $response
        );

        $endpoint = new \PayPro\Endpoints\Subscriptions($this->apiClient);
        $subscription = $endpoint->get('PS8PTGUPZTSLBP');

        $this->assertInstanceOf(\PayPro\Entities\Subscription::class, $subscription);
        $this->assertSame($subscription->id, 'PS8PTGUPZTSLBP');
        $this->assertSame($subscription->description, 'Unlimited Subscription');
        $this->assertSame($subscription->period, ['amount' => 2500, 'interval' => 'month', 'multiplier' => 1, 'vat' => 21.0]);
    }

    public function testIsCreatable()
    {
        $response = $this->getFixture('subscriptions/get.json');

        $this->stubRequest(
            'post',
            '/subscriptions',
            null,
            null,
            ['description' => 'Unlimited Subscription'],
            $response,
            201
        );

        $endpoint = new \PayPro\Endpoints\Subscriptions($this->apiClient);
        $subscription = $endpoint->create(['description' => 'Unlimited Subscription']);

        $this->assertInstanceOf(\PayPro\Entities\Subscription::class, $subscription);
    }
}
