<?php

namespace PayPro\Operations;

/**
 * Implements the update endpoint for resources. Should only be implemented by Entities that decent
 * from Resource.
 */
trait Update
{
    /**
     * Updates the resource
     *
     * @param array $body
     *
     * @throws \PayPro\Exception\ApiErrorException if the request fails
     *
     * @return static the updated resource
     */
    public function update($body)
    {
        return $this->apiRequest('patch', $this->resourceUrl(), [], [], $body);
    }
}
