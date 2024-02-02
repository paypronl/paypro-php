<?php

namespace PayPro\Operations;

use PayPro\Exception\ApiErrorException;

/**
 * Implements the get endpoint for resources. Should only used by Endpoint classes.
 */
trait Get
{
    /**
     * Retrieve a single resource from the API.
     *
     * @param string $id
     *
     * @return static the returned resource
     *
     * @throws ApiErrorException if the request fails
     */
    public function get($id)
    {
        return $this->apiRequest('get', static::resourceUrl() . '/' . \urlencode($id));
    }
}
