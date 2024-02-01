<?php

namespace PayPro\Exception;

/**
 * Base class of all exceptions thrown by this library.
 */
class ApiErrorException extends \Exception implements ExceptionInterface
{
    protected $httpStatus;
    protected $httpBody;
    protected $httpHeaders;
    protected $ppCode;

    /**
     * Create a new instance of an ApiErrorException
     *
     * @param string $message the exception message
     * @param null|int $httpStatus the HTTP status code
     * @param null|string $httpBody the body of the HTTP request
     * @param null|array $httpHeaders the headers of the HTTP request
     * @param null|string $ppCode the PayPro error code
     *
     * @return static
     */
    public static function create(
        $message,
        $httpStatus = null,
        $httpBody = null,
        $httpHeaders = null,
        $ppCode = null
    ) {

        $instance = new static($message);
        $instance->setHttpStatus($httpStatus);
        return $instance;
    }

    /**
     * Sets the HTTP status
     *
     * @param null|int $httpStatus
     */
    public function setHttpStatus($httpStatus)
    {
        $this->httpStatus = $httpStatus;
    }

    /**
     * Get the HTTP status
     *
     * @return null|int
     */
    public function getHttpStatus()
    {
        return $this->httpStatus;
    }

    /**
     * Sets the HTTP body
     *
     * @param null|string $httpBody
     */
    public function setHttpBody($httpBody)
    {
        $this->httpBody = $httpBody;
    }

    /**
     * Get the HTTP body
     *
     * @return null|string
     */
    public function getHttpBody()
    {
        return $this->httpBody;
    }

    /**
     * Sets the HTTP headers
     *
     * @param null|array $httpHeaders
     */
    public function setHttpHeaders($httpHeaders)
    {
        $this->httpHeaders = $httpHeaders;
    }

    /**
     * Get the HTTP headers
     *
     * @return null|array
     */
    public function getHttpHeaders()
    {
        return $this->httpHeaders;
    }

    /**
     * Sets the PayPro error code
     *
     * @param null|string $ppCode
     */
    public function setPpCode($ppCode)
    {
        $this->ppCode = $ppCode;
    }

    /**
     * Get the PayPro error code
     *
     * @return null|string
     */
    public function getPpCode()
    {
        return $this->ppCode;
    }

    /**
     * Returns the string representation of the exception
     */
    public function __toString()
    {
        $parentString = parent::__toString();
        $statusString = ($this->getHttpStatus()) ? '' : "Status {$this->getHttpStatus()}";

        return "Error sending request to PayPro: {$statusString}{$this->getMessage()}\n{$parentString}";
    }
}
