<?php

namespace PayPro\Entities;

use PayPro\Exception\ApiErrorException;
use PayPro\Operations\Request;
use PayPro\Operations\Update;

class Subscription extends Resource
{
    use Request;
    use Update;

    public function resourcePath()
    {
        return 'subscriptions';
    }

    /**
     * Cancels the subscription.
     *
     * @return static the canceled subscription
     *
     * @throws ApiErrorException if the request fails
     */
    public function cancel()
    {
        return $this->apiRequest('delete', $this->resourceUrl());
    }

    /**
     * Pauses the subscription.
     *
     * @return static the paused subscription
     *
     * @throws ApiErrorException if the request fails
     */
    public function pause()
    {
        $url = $this->resourceUrl() . '/pause';

        return $this->apiRequest('post', $url);
    }

    /**
     * Resumes the subscription.
     *
     * @return static the resumed subscription
     *
     * @throws ApiErrorException if the request fails
     */
    public function resume()
    {
        $url = $this->resourceUrl() . '/resume';

        return $this->apiRequest('post', $url);
    }

    /**
     * Returns all subscription periods of the subscription.
     *
     * @param mixed $params
     *
     * @return Collection a list with the subscription periods
     *
     * @throws ApiErrorException if the request fails
     */
    public function subscriptionPeriods($params = [])
    {
        $url = $this->resourceUrl() . '/subscription_periods';

        return $this->apiRequest('get', $url, $params);
    }

    /**
     * Creates a new subscription period for the Subscription.
     *
     * @param mixed $body
     *
     * @return SubscriptionPeriod the created subscription period
     *
     * @throws ApiErrorException if the request fails
     */
    public function createSubscriptionPeriod($body)
    {
        $url = $this->resourceUrl() . '/subscription_periods';

        return $this->apiRequest('post', $url, [], [], $body);
    }
}
