<?php

namespace PayPro\Entities;

class Refund extends Resource
{
    use \PayPro\Operations\Request;

    public function resourcePath()
    {
        return 'refunds';
    }

    /**
     * Cancels the refund
     *
     * @throws \PayPro\Exception\ApiErrorException if the request fails
     *
     * @return static the canceled refund
     */
    public function cancel()
    {
        return $this->apiRequest('delete', $this->resourceUrl());
    }
}
