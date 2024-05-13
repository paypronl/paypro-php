<?php

namespace PayPro\Entities;

use PayPro\ApiClient;
use PayPro\Util;

abstract class AbstractEntity implements \ArrayAccess
{
    /** @var array values returned by the API */
    protected $values;

    /** @var ApiClient client used to make requests */
    protected $client;

    /**
     * Construct a new instance of an Entity by setting the data returned as attributes of the
     * entity.
     *
     * @param array $data
     * @param null|ApiClient $client
     *
     * @return static
     */
    public function __construct($data, $client = null)
    {
        $this->client = $client;

        $attributes = Util::normalizeApiAttributes($data);
        $this->values = $this->convertAttributesToEntities($attributes);
    }

    /**
     * Gets the value from the values store.
     *
     * @param mixed $key
     */
    public function __get($key)
    {
        if (!empty($this->values) && \array_key_exists($key, $this->values)) {
            return $this->values[$key];
        }

        return null;
    }

    /**
     *  Sets the value in the values store and converts it to an Entity if possible.
     *
     * @param mixed $key
     * @param mixed $value
     */
    public function __set($key, $value)
    {
        $this->values[$key] = Util::toEntity($value, $this->client);
    }

    public function __debugInfo()
    {
        return $this->values;
    }

    // ArrayAccess methods

    #[\ReturnTypeWillChange]
    public function offsetSet($key, $value)
    {
        $this->{$key} = $value;
    }

    /**
     * @return bool
     */
    #[\ReturnTypeWillChange]
    public function offsetExists($key)
    {
        return \array_key_exists($key, $this->values);
    }

    #[\ReturnTypeWillChange]
    public function offsetUnset($key)
    {
        unset($this->{$key});
    }

    /**
     * @return mixed
     */
    #[\ReturnTypeWillChange]
    public function offsetGet($key)
    {
        return \array_key_exists($key, $this->values) ? $this->values[$key] : null;
    }

    // End ArrayAccess methods

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
     * Converts an array of attributes to an array of Entities when possible.
     *
     * @param array $attributes
     *
     * @return array the converted attributes
     */
    private function convertAttributesToEntities($attributes)
    {
        $newAttributes = [];

        foreach ($attributes as $key => $value) {
            $newAttributes[$key] = Util::toEntity($value, $this->client);
        }

        return $newAttributes;
    }
}
