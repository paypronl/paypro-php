<?php

namespace PayPro\HttpClient;

use PayPro\Exception\ApiConnectionException;
use PayPro\Exception\InvalidArgumentException;
use PayPro\PayPro;
use PayPro\Util;

class CurlClient implements HttpClientInterface
{
    protected $curlHandle;

    public function __destruct()
    {
        $this->closeCurlHandle();
    }

    /**
     * Do a request with the client.
     *
     * @param string $method
     * @param string $url
     * @param array $params
     * @param array $headers
     * @param null|string $body
     *
     * @return array{string, int, array}
     */
    public function request($method, $url, $params, $headers, $body)
    {
        $this->curlHandle = \curl_init();

        $curlOpts = [];
        $responseHeaders = [];

        switch ($method) {
            case 'get':
                $curlOpts[\CURLOPT_HTTPGET] = 1;

                if (\count($params) > 0) {
                    $encodedParameters = Util::encodeParameters($params);
                    $url = $url . '?' . $encodedParameters;
                }

                break;

            case 'post':
                $curlOpts[\CURLOPT_POST] = 1;
                $curlOpts[\CURLOPT_POSTFIELDS] = $body;

                break;

            case 'delete':
                $curlOpts[\CURLOPT_CUSTOMREQUEST] = 'DELETE';

                break;

            case 'patch':
                $curlOpts[\CURLOPT_CUSTOMREQUEST] = 'PATCH';
                $curlOpts[\CURLOPT_POSTFIELDS] = $body;

                break;

            default:
                throw new InvalidArgumentException("Unknown method given {$method}");
        }

        $curlOpts[\CURLOPT_URL] = $url;
        $curlOpts[\CURLOPT_RETURNTRANSFER] = true;
        $curlOpts[\CURLOPT_HTTPHEADER] = $this->rawHeaders($headers);
        $curlOpts[\CURLOPT_CAINFO] = PayPro::getCaBundlePath();
        $curlOpts[\CURLOPT_CONNECTTIMEOUT] = PayPro::getTimeout();

        $curlOpts[\CURLOPT_HEADERFUNCTION] = function ($curl, $line) use (&$responseHeaders) {
            return CurlClient::parseHeaderLines($line, $responseHeaders);
        };

        if (!PayPro::getVerifySslCertificates()) {
            $curlOpts[\CURLOPT_SSL_VERIFYPEER] = false;
        }

        \curl_setopt_array($this->curlHandle, $curlOpts);

        $responseBody = \curl_exec($this->curlHandle);

        if (false === $responseBody) {
            $this->handleError(\curl_errno($this->curlHandle), \curl_error($this->curlHandle));
        }

        $responseCode = \curl_getinfo($this->curlHandle, \CURLINFO_HTTP_CODE);

        $this->closeCurlHandle();

        return [$responseBody, $responseCode, $responseHeaders];
    }

    /**
     * Handles the curl errors and converts it to an exception.
     *
     * @param int $errorCode
     * @param string $errorMessage
     *
     * @throws ApiConnectionException
     */
    private function handleError($errorCode, $errorMessage)
    {
        switch ($errorCode) {
            case \CURLE_COULDNT_CONNECT:
            case \CURLE_COULDNT_RESOLVE_HOST:
            case \CURLE_OPERATION_TIMEOUTED:
                $message = 'Failed to make a connection to the PayPro API. ' .
                           'This could indicate a DNS issue or because you have no internet connection.';

                // no break
            case \CURLE_SSL_CACERT:
            case \CURLE_SSL_PEER_CERTIFICATE:
                $message = 'Failed to create a secure connection with the PayPro API. ' .
                           'Please make sure https://api.paypro.nl certificate is accepted in your ' .
                           'network.';

                // no break
            default:
                $message = "Could not connect to the PayPro API. Curl error: {$errorMessage}";
        }

        $message .= "\n\n Connection error [{$errorCode}]: {$message}";

        throw new ApiConnectionException($message);
    }

    /**
     * Converts an array of headers to raw headers.
     *
     * @param array $headers
     *
     * @return array
     */
    private function rawHeaders($headers)
    {
        $rawHeaders = [];

        foreach ($headers as $header => $value) {
            $rawHeaders[] = $header . ': ' . $value;
        }

        return $rawHeaders;
    }

    /**
     * Used in the callback for parsing Curl headers.
     *
     * @param array &$headers
     *
     * @return int
     */
    private static function parseHeaderLines($line, &$headers)
    {
        if (false === \strpos($line, ':')) {
            return \strlen($line);
        }
        list($key, $value) = \explode(':', \trim($line), 2);
        $headers[\trim($key)] = \trim($value);

        return \strlen($line);
    }

    /**
     * Closes the curl handle if it exists.
     */
    private function closeCurlHandle()
    {
        if (null !== $this->curlHandle) {
            \curl_close($this->curlHandle);
            $this->curlHandle = null;
        }
    }
}
