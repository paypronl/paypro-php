<?php

namespace PayPro\Endpoints;

use PayPro\Entities\Collection;
use PayPro\Entities\Subscription;
use PayPro\TestCase;
use PayPro\TestHelper;

final class SubscriptionsTest extends TestCase
{
    use TestHelper;

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

        $endpoint = new Subscriptions($this->apiClient);
        $list = $endpoint->list();

        self::assertInstanceOf(Collection::class, $list);
        self::assertInstanceOf(Subscription::class, $list->first());
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

        $endpoint = new Subscriptions($this->apiClient);
        $subscription = $endpoint->get('PS8PTGUPZTSLBP');

        self::assertInstanceOf(Subscription::class, $subscription);
        self::assertSame($subscription->id, 'PS8PTGUPZTSLBP');
        self::assertSame($subscription->description, 'Unlimited Subscription');
        self::assertEqualsCanonicalizing($subscription->period, ['amount' => 2500, 'interval' => 'month', 'multiplier' => 1, 'vat' => 21.0]);
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

        $endpoint = new Subscriptions($this->apiClient);
        $subscription = $endpoint->create(['description' => 'Unlimited Subscription']);

        self::assertInstanceOf(Subscription::class, $subscription);
    }
}
