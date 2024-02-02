<?php

namespace PayPro\Operations;

use PayPro\Exception\ApiErrorException;

/**
 * Implements the delete endpoint for resources. Should only be implemented by Entities that decent
 * from Resource.
 */
trait Delete
{
    /**
     * Deletes the resource.
     *
     * @return static the deleted resource
     *
     * @throws ApiErrorException if the request fails
     */
    public function delete()
    {
        return $this->apiRequest('delete', $this->resourceUrl());
    }
}
