<?php

namespace PayPro\Operations;

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
     * @throws \PayPro\Exception\ApiErrorException if the request fails
     *
     * @return static the created resource
     */
    public function create($body)
    {
        return $this->apiRequest('post', static::resourceUrl(), [], [], $body);
    }
}
