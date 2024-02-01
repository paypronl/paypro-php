<?php

namespace PayPro\Operations;

/**
 * Implements the get endpoint for resources. Should only used by Endpoint classes.
 */
trait Get
{
    /**
     * Retrieve a single resource from the API
     *
     * @param string $id
     *
     * @throws \PayPro\Exception\ApiErrorException if the request fails
     *
     * @return static the returned resource
     */
    public function get($id)
    {
        return $this->apiRequest('get', static::resourceUrl() . '/' . \urlencode($id));
    }
}
