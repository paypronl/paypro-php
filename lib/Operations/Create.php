<?php

namespace PayPro\Operations;

use PayPro\Exception\ApiErrorException;

/**
 * Implements the list endpoint for resources. Should only used by Endpoint classes.
 */
trait Create
{
    /**
     * Create a new resource.
     *
     * @param array $body
     *
     * @return static the created resource
     *
     * @throws ApiErrorException if the request fails
     */
    public function create($body)
    {
        return $this->apiRequest('post', static::resourceUrl(), [], [], $body);
    }
}
