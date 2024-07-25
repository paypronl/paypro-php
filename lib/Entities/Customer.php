<?php

namespace PayPro\Entities;

use PayPro\Exception\ApiErrorException;
use PayPro\Operations\Delete;
use PayPro\Operations\Request;
use PayPro\Operations\Update;

class Customer extends Resource
{
    use Delete;
    use Request;
    use Update;

    public function resourcePath()
    {
        return 'customers';
    }

    /**
     * Returns all mandates for this customer.
     *
     * @param array $params
     *
     * @return Collection a list with the mandates
     *
     * @throws ApiErrorException if the request fails
     */
    public function mandates($params = [])
    {
        $url = $this->resourceUrl() . '/mandates';

        return $this->apiRequest('get', $url, $params);
    }
}
