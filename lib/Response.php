<?php

namespace PayPro;

class Response
{
    /** @var array parsed body of the response */
    private $data;

    /** @var string raw body of the response */
    private $rawBody;

    /** @var int status code */
    private $status;

    /** @var string request id send by the API */
    private $requestId;

    /** @var array headers of the response */
    private $headers;

    /**
     * Construct a new instance of the Response.
     *
     * @param string $body the response body
     * @param int $status the response status code
     * @param array $headers the response headers
     *
     * @return static
     *
     * @throws Exception\ApiErrorException when the response body is invalid JSON
     */
    public function __construct($body, $status, $headers)
    {
        $jsonBody = \json_decode($body, true);
        $jsonError = \json_last_error();

        if (null === $jsonBody && \JSON_ERROR_NONE !== $jsonError) {
            $message = 'Invalid response from API. The JSON returned in the body is not valid.';

            throw new Exception\ApiErrorException($message);
        }

        $this->rawBody = $body;
        $this->data = $jsonBody;
        $this->status = $status;

        if (\array_key_exists('X-Request-Id', $headers)) {
            $this->requestId = $headers['X-Request-Id'];
        }

        $this->headers = $headers;
    }

    /**
     * Get the parsed body as an array.
     *
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Get the raw body.
     *
     * @return string
     */
    public function getRawBody()
    {
        return $this->rawBody;
    }

    /**
     * Get the HTTP status code.
     *
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Get the request id send by the API.
     *
     * @return null|string
     */
    public function getRequestId()
    {
        return $this->requestId;
    }

    /**
     * Get the headers.
     *
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }
}
