<?php

namespace PayPro;

class PayPro
{
    /** @var string The PayPro API key to authorize your requests */
    public static $apiKey;

    /** @var string The base URL of the API */
    public static $apiUrl = 'https://api.paypro.nl';

    /** @var string The path to the CA bundle */
    public static $caBundlePath = null;

    /** @var bool Verify SSL certiticates */
    public static $verifySslCertificates = true;

    /** @var int The amount of seconds when requests will timeout */
    public static $timeout = 30;

    public const VERSION = '0.1.0';

    /**
     * Gets the default API key
     *
     * @return string
     */
    public static function getApiKey()
    {
        return self::$apiKey;
    }

    /**
     * Sets the default API key
     *
     * @param string $apiKey
     */
    public static function setApiKey($apiKey)
    {
        self::$apiKey = $apiKey;
    }

    /**
     * Gets the default API url
     *
     * @return string
     */
    public static function getApiUrl()
    {
        return self::$apiUrl;
    }

    /**
     * Gets the path to the ca bundle
     *
     * @return string
     */
    public static function getCaBundlePath()
    {
        return self::$caBundlePath ?: self::getDefaultCaBundlePath();
    }

    /**
     * Sets the path to the ca bundle
     *
     * @param string $caBundlePath
     */
    public static function setCaBundlePath($caBundlePath)
    {
        self::$caBundlePath = $caBundlePath;
    }

    /**
     * Get the setting if SSL certificates should be verified
     *
     * @return bool
     */
    public static function getVerifySslCertificates()
    {
        return self::$verifySslCertificates;
    }

    /**
     * Sets if the SSL certificates should be verified
     *
     * @param bool $verify
     */
    public static function setVerifySslCetificates($verify)
    {
        self::$verifySslCertificates = $verify;
    }

    /**
     * Get the default setting for the timeout in seconds
     *
     * @return int
     */
    public static function getTimeout()
    {
        return self::$timeout;
    }

    /**
     * Sets the timeout for requests in seconds
     *
     * @param int $timeout
     */
    public static function setTimeout($timeout)
    {
        self::$timeout = $timeout;
    }

    /**
     * Get path to the packaged ca bundle
     *
     * @return string
     */
    private static function getDefaultCaBundlePath()
    {
        return \realpath(__DIR__ . '/../data/cacert.pem');
    }

    /**
     * Get the version of this library
     *
     * @return string
     */
    public static function getVersion()
    {
        return PayPro::VERSION;
    }
}
