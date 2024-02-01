<?php

namespace PayPro;

class Client
{
    /** @var string default base URL for the PayPro API */
    public const DEFAULT_API_URL = 'https://api.paypro.nl';

    /** @var array<string, null|string> */
    public const DEFAULT_CONFIG = [
        'api_key' => null,
        'api_url' => self::DEFAULT_API_URL
    ];

    /** @var ApiClient */
    private $apiClient;

    /** @var \PayPro\Endpoints\Chargebacks */
    public $chargebacks;

    /** @var \PayPro\Endpoints\Customers */
    public $customers;

    /** @var \PayPro\Endpoints\Events */
    public $events;

    /** @var \PayPro\Endpoints\Payments */
    public $payments;

    /** @var \PayPro\Endpoints\Refunds */
    public $refunds;

    /** @var \PayPro\Endpoints\SubscriptionPeriods */
    public $subscriptionPeriods;

    /** @var \PayPro\Endpoints\Subscriptions */
    public $subscriptions;

    /** @var \PayPro\Endpoints\Webhooks */
    public $webhooks;

    /**
     * Initializes a new instance of the {@link Client} class.
     *
     * The constructor takes a single argument which can be a string or an array. When supplying a
     * string it should be the API key. When it is an array it will be the config settings.
     *
     * - api_key (null|string): The PayPro API key
     * - api_url (string): The base URL for the PayPro API. You can change this for testing or
     *   mocking purposes.
     *
     * @param array<string, mixed>|string $config the API key as a string, or an array containing the
     *   the client config
     */
    public function __construct($config = [])
    {
        if (\is_string($config)) {
            $config = ['api_key' => $config];
        } elseif (!\is_array($config)) {
            throw new \PayPro\Exception\InvalidArgumentException('$config must be a string or array');
        }

        $config = \array_merge(self::DEFAULT_CONFIG, $config);
        $this->validateConfig($config);

        $this->apiClient = new ApiClient($config['api_key'], $config['api_url']);

        $this->setupEndpoints();
    }

    /**
     * Sets up the endpoints to allow '$client->payments' code to work.
     */
    private function setupEndpoints()
    {
        $this->chargebacks = new \PayPro\Endpoints\Chargebacks($this->apiClient);
        $this->customers = new \PayPro\Endpoints\Customers($this->apiClient);
        $this->events = new \PayPro\Endpoints\Events($this->apiClient);
        $this->payments = new \PayPro\Endpoints\Payments($this->apiClient);
        $this->refunds = new \PayPro\Endpoints\Refunds($this->apiClient);
        $this->subscriptionPeriods = new \PayPro\Endpoints\SubscriptionPeriods($this->apiClient);
        $this->subscriptions = new \PayPro\Endpoints\Subscriptions($this->apiClient);
        $this->webhooks = new \PayPro\Endpoints\Webhooks($this->apiClient);
    }

    /**
     * @param array<string, mixed> $config
     *
     * @throws \PayPro\Exception\InvalidArgumentException
     */
    private function validateConfig($config)
    {
        if ($config['api_key'] !== null && !\is_string($config['api_key'])) {
            throw new \PayPro\Exception\InvalidArgumentException('api_key must be null or a string');
        }

        if ($config['api_key'] !== null && $config['api_key'] === '') {
            throw new \PayPro\Exception\InvalidArgumentException('api_key cannot be an empty string');
        }

        if ($config['api_key'] !== null && (\preg_match('/\s/', $config['api_key']))) {
            throw new \PayPro\Exception\InvalidArgumentException('api_key cannot contain whitespaces');
        }
    }
}
