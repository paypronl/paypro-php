<?php

namespace PayPro\HttpClient;

interface HttpClientInterface
{
    /**
     * Sends a request to the PayPro API
     *
     * @param string $method
     * @param string $url
     * @param array $params
     * @param array $headers
     * @param null|string $body
     *
     * @return array{string, int, array}
     */
    public function request($method, $url, $params, $headers, $body);
}
