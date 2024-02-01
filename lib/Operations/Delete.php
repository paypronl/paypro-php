<?php

namespace PayPro\Operations;

/**
 * Implements the delete endpoint for resources. Should only be implemented by Entities that decent
 * from Resource.
 */
trait Delete
{
    /**
     * Deletes the resource
     *
     * @throws \PayPro\Exception\ApiErrorException if the request fails
     *
     * @return static the deleted resource
     */
    public function delete()
    {
        return $this->apiRequest('delete', $this->resourceUrl());
    }
}
