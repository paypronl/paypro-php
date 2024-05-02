<?php

namespace PayPro;

use PayPro\Endpoints\Chargebacks;
use PayPro\Endpoints\Customers;
use PayPro\Endpoints\Events;
use PayPro\Endpoints\InstallmentPlanPeriods;
use PayPro\Endpoints\InstallmentPlans;
use PayPro\Endpoints\Mandates;
use PayPro\Endpoints\Payments;
use PayPro\Endpoints\Refunds;
use PayPro\Endpoints\SubscriptionPeriods;
use PayPro\Endpoints\Subscriptions;
use PayPro\Endpoints\Webhooks;
use PayPro\Exception\InvalidArgumentException;

class Client
{
    /** @var string default base URL for the PayPro API */
    public const DEFAULT_API_URL = 'https://api.paypro.nl';

    /** @var array<string, null|string> */
    public const DEFAULT_CONFIG = [
        'api_key' => null,
        'api_url' => self::DEFAULT_API_URL,
    ];

    /** @var Chargebacks */
    public $chargebacks;

    /** @var Customers */
    public $customers;

    /** @var InstallmentPlanPeriods */
    public $installmentPlanPeriods;

    /** @var InstallmentPlans */
    public $installmentPlans;

    /** @var Events */
    public $events;

    /** @var Mandates */
    public $mandates;

    /** @var Payments */
    public $payments;

    /** @var Refunds */
    public $refunds;

    /** @var SubscriptionPeriods */
    public $subscriptionPeriods;

    /** @var Subscriptions */
    public $subscriptions;

    /** @var Webhooks */
    public $webhooks;

    /** @var ApiClient */
    private $apiClient;

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
            throw new InvalidArgumentException('$config must be a string or array');
        }

        $config = array_merge(self::DEFAULT_CONFIG, $config);
        $this->validateConfig($config);

        $this->apiClient = new ApiClient($config['api_key'], $config['api_url']);

        $this->setupEndpoints();
    }

    /**
     * Sets up the endpoints to allow '$client->payments' code to work.
     */
    private function setupEndpoints()
    {
        $this->chargebacks = new Chargebacks($this->apiClient);
        $this->customers = new Customers($this->apiClient);
        $this->installmentPlanPeriods = new InstallmentPlanPeriods($this->apiClient);
        $this->installmentPlans = new InstallmentPlans($this->apiClient);
        $this->events = new Events($this->apiClient);
        $this->mandates = new Mandates($this->apiClient);
        $this->payments = new Payments($this->apiClient);
        $this->refunds = new Refunds($this->apiClient);
        $this->subscriptionPeriods = new SubscriptionPeriods($this->apiClient);
        $this->subscriptions = new Subscriptions($this->apiClient);
        $this->webhooks = new Webhooks($this->apiClient);
    }

    /**
     * @param array<string, mixed> $config
     *
     * @throws InvalidArgumentException
     */
    private function validateConfig($config)
    {
        if (null !== $config['api_key'] && !\is_string($config['api_key'])) {
            throw new InvalidArgumentException('api_key must be null or a string');
        }

        if (null !== $config['api_key'] && '' === $config['api_key']) {
            throw new InvalidArgumentException('api_key cannot be an empty string');
        }

        if (null !== $config['api_key'] && preg_match('/\s/', $config['api_key'])) {
            throw new InvalidArgumentException('api_key cannot contain whitespaces');
        }
    }
}
