<?php

namespace PayPro\Endpoints;

use PayPro\ApiClient;
use PayPro\Operations\Request;

abstract class AbstractEndpoint
{
    use Request;

    /** @var ApiClient the client to do requests */
    protected $client;

    /**
     * Construct a new instance of an Operations by setting the data returned as attributes of the.
     *
     * @param null|ApiClient $client
     *
     * @return static
     */
    public function __construct($client)
    {
        $this->client = $client;
    }

    /**
     * Gets the client.
     *
     * @return null|ApiClient
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Returns the URL of this specific endpoint.
     *
     * @return string
     */
    public function resourceUrl()
    {
        return '/' . $this->resourcePath();
    }

    /**
     * Returns the path of this specific resource.
     *
     * @return string
     */
    abstract public function resourcePath();
}
