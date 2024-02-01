<?php

namespace PayPro\Operations;

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
     * @throws \PayPro\Exception\ApiErrorException if the request fails
     *
     * @return \PayPro\Entities\Collection a list of the requested resources
     */
    public function list($params = [])
    {
        return $this->apiRequest('get', static::resourceUrl(), $params);
    }
}
