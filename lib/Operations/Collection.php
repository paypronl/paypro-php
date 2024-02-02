<?php

namespace PayPro\Operations;

use PayPro\Exception\ApiErrorException;

/**
 * Implements the list endpoint for resources. Should only used by Endpoint classes.
 */
trait Collection
{
    /**
     * Retrieves a list from the API.
     *
     * @param array $params
     *
     * @return \PayPro\Entities\Collection a list of the requested resources
     *
     * @throws ApiErrorException if the request fails
     */
    public function list($params = [])
    {
        return $this->apiRequest('get', static::resourceUrl(), $params);
    }
}
