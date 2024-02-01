<?php

namespace PayPro\Entities;

class Payment extends Resource
{
    use \PayPro\Operations\Request;

    public function resourcePath()
    {
        return 'payments';
    }

    /**
     * Cancels the payment
     *
     * @throws \PayPro\Exception\ApiErrorException if the request fails
     *
     * @return static the canceled payment
     */
    public function cancel()
    {
        return $this->apiRequest('delete', $this->resourceUrl());
    }

    /**
     * Creates a refund object for the payment
     *
     * @throws \PayPro\Exception\ApiErrorException if the request fails
     *
     * @return \PayPro\Entities\Refund the created refund
     */
    public function refund($body)
    {
        $url = $this->resourceUrl() . '/refunds';
        return $this->apiRequest('post', $url, [], [], $body);
    }

    /**
     * Returns all refunds for this payment
     *
     * @param array $params
     *
     * @throws \PayPro\Exception\ApiErrorException if the request fails
     *
     * @return \PayPro\Entities\Collection a list with the refunds
     */
    public function refunds($params = [])
    {
        $url = $this->resourceUrl() . '/refunds';
        return $this->apiRequest('get', $url, $params);
    }

    /**
     * Returns all chargebacks for this payment
     *
     * @param array $params
     *
     * @throws \PayPro\Exception\ApiErrorException if the request fails
     *
     * @return \PayPro\Entities\Collection a list with the chargebacks
     */
    public function chargebacks($params = [])
    {
        $url = $this->resourceUrl() . '/chargebacks';
        return $this->apiRequest('get', $url, $params);
    }
}
