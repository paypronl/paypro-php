<?php

namespace PayPro;

use PayPro\HttpClient\CurlClient;
use PayPro\HttpClient\HttpClientInterface;

class ApiClient
{
    /** @var string api key to be used for requests */
    private $apiKey;

    /** @var string api url to be used for requests */
    private $apiUrl;

    /** @var HttpClientInterface the http client used for requests */
    private static $httpClient;

    /**
     * @param string $apiKey
     * @param string $apiUrl
     */
    public function __construct($apiKey = null, $apiUrl = null)
    {
        $this->apiKey = $apiKey;

        if (null === $apiUrl) {
            $apiUrl = PayPro::getApiUrl();
        }

        $this->apiUrl = $apiUrl;
    }

    /**
     * Does a request with the specified http client. Parses the request and returns a Response
     * instance.
     *
     * @param 'delete'|'get'|'patch'|'post' $method the method for the request
     * @param string $path the path that will be added to the base URL
     * @param array $params the params for the query parameter
     * @param array $headers the headers for the request
     * @param null|string $body the body fot the request
     *
     * @return Response the response of the request
     *
     * @throws Exception\AuthenticationException
     * @throws Exception\ResourceNotFoundException
     * @throws Exception\ValidationException
     * @throws Exception\ApiErrorException
     */
    public function request($method, $path, $params = [], $headers = [], $body = null)
    {
        $this->checkApiKey();

        $url = $this->requestUrl($path);
        $headers = array_merge($this->defaultHeaders(), $headers);

        list($body, $status, $rheaders) = $this->httpClient()->request($method, $url, $params, $headers, $body);

        $response = new Response($body, $status, $rheaders);

        if ($response->getStatus() >= 400) {
            return $this->handleErrorResponse($response);
        }

        return $response;
    }

    /**
     * Sets the HTTP client. Can be used if you want to use a different HTTP client.
     *
     * @param HttpClientInterface $client
     */
    public static function setHttpClient($client)
    {
        self::$httpClient = $client;
    }

    /**
     * Handles the case when the API returns an error.
     *
     * @param Response $response the response of the request
     *
     * @throws Exception\AuthenticationException
     * @throws Exception\ResourceNotFoundException
     * @throws Exception\ValidationException
     * @throws Exception\ApiErrorException
     */
    private function handleErrorResponse($response)
    {
        $body = $response->getRawBody();
        $status = $response->getStatus();
        $headers = $response->getHeaders();

        switch ($response->getStatus()) {
            case 401:
                $message = 'Invalid API key supplied. Make sure to set a correct API key. ' .
                           'You can find your API key in the PayPro dashboard at ' .
                           '"https://app.paypro.nl/developers/api-keys".';

                throw Exception\AuthenticationException::create($message, $status, $body, $headers);

            case 404:
                throw Exception\ResourceNotFoundException::create('Resource not found', $status, $body, $headers);

            case 422:
                $responseData = $response->getData()['error'];

                $errorCode = isset($responseData['type']) ? $responseData['type'] : null;
                $errorMessage = isset($responseData['message']) ? $responseData['message'] : null;
                $errorParam = isset($responseData['param']) ? $responseData['param'] : null;

                $message = "Validation error - param: {$errorParam} because {$errorMessage}";

                throw Exception\ValidationException::create($message, $status, $body, $headers, $errorCode);

            default:
                throw Exception\ApiErrorException::create('Unknown error', $status, $body, $headers);
        }
    }

    /**
     * Returns a list of default headers to be set in the request.
     *
     * @return array
     */
    private function defaultHeaders()
    {
        return [
            'Content-Type' => 'application/json',
            'Authorization' => "Bearer {$this->apiKey}",
            'User-Agent' => $this->userAgent(),
        ];
    }

    /**
     * Checks if the API key has been set in any way. It will try to set the default if not set.
     * If it is still null it throws an Exception\AuthenticationException.
     *
     * @throws Exception\AuthenticationException when api key is null
     */
    private function checkApiKey()
    {
        if (null === $this->apiKey) {
            $this->apiKey = PayPro::getApiKey();
        }

        if (null === $this->apiKey) {
            $message = 'API key not set. ' .
                       'Make sure to set the API key with "PayPro::setApiKey(<API_KEY>)". ' .
                       'You can find your API key in the PayPro dashboard at "https://app.paypro.' .
                       'nl/developers/api-keys".';

            throw new Exception\AuthenticationException($message);
        }
    }

    /**
     * Generates the userAgent to be set in the request.
     *
     * @return string
     */
    private function userAgent()
    {
        return 'PayPro ' . PayPro::getVersion() . ' / PHP ' . PHP_VERSION_ID . ' / OpenSSL ' . OPENSSL_VERSION_NUMBER;
    }

    /**
     * Returns the request url with the supplied path.
     *
     * @param mixed $path
     *
     * @return string
     */
    private function requestUrl($path)
    {
        return "{$this->apiUrl}$path";
    }

    /**
     * Get the HTTP client set for this class. If not set it will create a new instance of the http
     * client.
     *
     * @return HttpClientInterface
     */
    private function httpClient()
    {
        if (!self::$httpClient) {
            self::$httpClient = new CurlClient();
        }

        return self::$httpClient;
    }
}
