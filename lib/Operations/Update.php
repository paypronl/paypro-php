<?php

namespace PayPro\Operations;

use PayPro\Exception\ApiErrorException;

/**
 * Implements the update endpoint for resources. Should only be implemented by Entities that decent
 * from Resource.
 */
trait Update
{
    /**
     * Updates the resource.
     *
     * @param array $body
     *
     * @return static the updated resource
     *
     * @throws ApiErrorException if the request fails
     */
    public function update($body)
    {
        return $this->apiRequest('patch', $this->resourceUrl(), [], [], $body);
    }
}
