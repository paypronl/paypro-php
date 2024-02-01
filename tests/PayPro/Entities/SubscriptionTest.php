<?php

namespace PayPro\Entities;

final class SubscriptionTest extends \PayPro\TestCase
{
    use \PayPro\TestHelper;

    public function testUpdate()
    {
        $response = $this->getFixture('subscriptions/get.json');
        $data = \json_decode($response, true);

        $this->stubRequest(
            'patch',
            '/subscriptions/PS8PTGUPZTSLBP',
            null,
            null,
            ['description' => 'Limited Subscription'],
            $response
        );

        $subscriptions = new \PayPro\Entities\Subscription($data, $this->apiClient);

        $responseSubscription = $subscriptions->update(['description' => 'Limited Subscription']);
        $this->assertInstanceOf(\PayPro\Entities\Subscription::class, $responseSubscription);
    }

    public function testCancel()
    {
        $response = $this->getFixture('subscriptions/get.json');
        $data = \json_decode($response, true);

        $this->stubRequest(
            'delete',
            '/subscriptions/PS8PTGUPZTSLBP',
            null,
            null,
            null,
            $response
        );

        $subscription = new \PayPro\Entities\Subscription($data, $this->apiClient);

        $responseSubscription = $subscription->cancel();
        $this->assertInstanceOf(\PayPro\Entities\Subscription::class, $responseSubscription);
    }

    public function testPause()
    {
        $response = $this->getFixture('subscriptions/get.json');
        $data = \json_decode($response, true);

        $this->stubRequest(
            'post',
            '/subscriptions/PS8PTGUPZTSLBP/pause',
            null,
            null,
            null,
            $response
        );

        $subscription = new \PayPro\Entities\Subscription($data, $this->apiClient);

        $responseSubscription = $subscription->pause();
        $this->assertInstanceOf(\PayPro\Entities\Subscription::class, $responseSubscription);
    }

    public function testResume()
    {
        $response = $this->getFixture('subscriptions/get.json');
        $data = \json_decode($response, true);

        $this->stubRequest(
            'post',
            '/subscriptions/PS8PTGUPZTSLBP/resume',
            null,
            null,
            null,
            $response
        );

        $subscription = new \PayPro\Entities\Subscription($data, $this->apiClient);

        $responseSubscription = $subscription->resume();
        $this->assertInstanceOf(\PayPro\Entities\Subscription::class, $responseSubscription);
    }

    public function testSubscriptionPeriods()
    {
        $response = $this->getFixture('subscriptions/subscription_periods.json');
        $data = \json_decode($this->getFixture('subscriptions/get.json'), true);

        $this->stubRequest(
            'get',
            '/subscriptions/PS8PTGUPZTSLBP/subscription_periods',
            null,
            null,
            null,
            $response
        );

        $subscription = new \PayPro\Entities\Subscription($data, $this->apiClient);

        $subscriptionPeriods = $subscription->subscriptionPeriods();
        $this->assertInstanceOf(\PayPro\Entities\Collection::class, $subscriptionPeriods);
        $this->assertInstanceOf(\PayPro\Entities\SubscriptionPeriod::class, $subscriptionPeriods->first());
    }

    public function testCreateSubscriptionPeriods()
    {
        $response = $this->getFixture('subscription_periods/get.json');
        $data = \json_decode($this->getFixture('subscriptions/get.json'), true);

        $this->stubRequest(
            'post',
            '/subscriptions/PS8PTGUPZTSLBP/subscription_periods',
            null,
            null,
            ['amount' => 5000],
            $response,
            201
        );

        $subscription = new \PayPro\Entities\Subscription($data, $this->apiClient);

        $subscriptionPeriod = $subscription->createSubscriptionPeriod(['amount' => 5000]);
        $this->assertInstanceOf(\PayPro\Entities\SubscriptionPeriod::class, $subscriptionPeriod);
    }
}
