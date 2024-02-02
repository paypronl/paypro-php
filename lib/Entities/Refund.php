<?php

namespace PayPro\Entities;

use PayPro\Exception\ApiErrorException;
use PayPro\Operations\Request;

class Refund extends Resource
{
    use Request;

    public function resourcePath()
    {
        return 'refunds';
    }

    /**
     * Cancels the refund.
     *
     * @return static the canceled refund
     *
     * @throws ApiErrorException if the request fails
     */
    public function cancel()
    {
        return $this->apiRequest('delete', $this->resourceUrl());
    }
}
