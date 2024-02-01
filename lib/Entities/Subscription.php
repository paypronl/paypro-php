<?php

namespace PayPro\Entities;

class Subscription extends Resource
{
    use \PayPro\Operations\Request;
    use \PayPro\Operations\Update;

    public function resourcePath()
    {
        return 'subscriptions';
    }

    /**
     * Cancels the subscription
     *
     * @throws \PayPro\Exception\ApiErrorException if the request fails
     *
     * @return static the canceled subscription
     */
    public function cancel()
    {
        return $this->apiRequest('delete', $this->resourceUrl());
    }

    /**
     * Pauses the subscription
     *
     * @throws \PayPro\Exception\ApiErrorException if the request fails
     *
     * @return static the paused subscription
     */
    public function pause()
    {
        $url = $this->resourceUrl() . '/pause';
        return $this->apiRequest('post', $url);
    }

    /**
     * Resumes the subscription
     *
     * @throws \PayPro\Exception\ApiErrorException if the request fails
     *
     * @return static the resumed subscription
     */
    public function resume()
    {
        $url = $this->resourceUrl() . '/resume';
        return $this->apiRequest('post', $url);
    }

    /**
     * Returns all subscription periods of the subscription
     *
     * @throws \PayPro\Exception\ApiErrorException if the request fails
     *
     * @return \PayPro\Entities\Collection a list with the subscription periods
     */
    public function subscriptionPeriods($params = [])
    {
        $url = $this->resourceUrl() . '/subscription_periods';
        return $this->apiRequest('get', $url, $params);
    }

    /**
     * Creates a new subscription period for the Subscription.
     *
     * @throws \PayPro\Exception\ApiErrorException if the request fails
     *
     * @return \PayPro\Entities\SubscriptionPeriod the created subscription period
     */
    public function createSubscriptionPeriod($body)
    {
        $url = $this->resourceUrl() . '/subscription_periods';
        return $this->apiRequest('post', $url, [], [], $body);
    }
}
