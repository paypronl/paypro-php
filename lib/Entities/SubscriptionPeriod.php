<?php

namespace PayPro\Entities;

use PayPro\Exception\ApiErrorException;
use PayPro\Operations\Request;

class SubscriptionPeriod extends Resource
{
    use Request;

    public function resourcePath()
    {
        return 'subscription_periods';
    }

    /**
     * Returns all payments of the subscription period.
     *
     * @param mixed $params
     *
     * @return Collection of a list with the payments
     *
     * @throws ApiErrorException if the request fails
     */
    public function payments($params = [])
    {
        $url = $this->resourceUrl() . '/payments';

        return $this->apiRequest('get', $url, $params);
    }
}
