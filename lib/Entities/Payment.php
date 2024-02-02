<?php

namespace PayPro\Entities;

use PayPro\Exception\ApiErrorException;
use PayPro\Operations\Request;

class Payment extends Resource
{
    use Request;

    public function resourcePath()
    {
        return 'payments';
    }

    /**
     * Cancels the payment.
     *
     * @return static the canceled payment
     *
     * @throws ApiErrorException if the request fails
     */
    public function cancel()
    {
        return $this->apiRequest('delete', $this->resourceUrl());
    }

    /**
     * Creates a refund object for the payment.
     *
     * @param mixed $body
     *
     * @return Refund the created refund
     *
     * @throws ApiErrorException if the request fails
     */
    public function refund($body)
    {
        $url = $this->resourceUrl() . '/refunds';

        return $this->apiRequest('post', $url, [], [], $body);
    }

    /**
     * Returns all refunds for this payment.
     *
     * @param array $params
     *
     * @return Collection a list with the refunds
     *
     * @throws ApiErrorException if the request fails
     */
    public function refunds($params = [])
    {
        $url = $this->resourceUrl() . '/refunds';

        return $this->apiRequest('get', $url, $params);
    }

    /**
     * Returns all chargebacks for this payment.
     *
     * @param array $params
     *
     * @return Collection a list with the chargebacks
     *
     * @throws ApiErrorException if the request fails
     */
    public function chargebacks($params = [])
    {
        $url = $this->resourceUrl() . '/chargebacks';

        return $this->apiRequest('get', $url, $params);
    }
}
