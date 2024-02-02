<?php

namespace PayPro\Operations;

use PayPro\Exception\ApiErrorException;
use PayPro\Util;

/**
 * Implements the apiRequest method that allows Entities and Endpoints to do API requests and
 * convert the result into a valid entity. Can be used by both Entity and Endpoint classes.
 */
trait Request
{
    /**
     * Do a request to the API and convert the result into an entity.
     *
     * @param string $method
     * @param string $path
     * @param array $params
     * @param array $headers
     * @param null|array $body
     *
     * @return mixed
     *
     * @throws ApiErrorException if the request fails
     */
    protected function apiRequest($method, $path, $params = [], $headers = [], $body = null)
    {
        $body = null !== $body ? \json_encode($body) : null;
        $response = $this->getClient()->request($method, $path, $params, $headers, $body);

        return Util::toEntity($response->getData(), $this->getClient(), $params);
    }
}
