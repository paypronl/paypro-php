<?php

namespace PayPro;

abstract class Util
{
    /**
     * Tries to find the entityClass based on the types returned by the API. If no Entity can be
     * found it will return the default Entity.
     *
     * @param string $type the type string
     *
     * @return string
     */
    public static function entityClass($type)
    {
        $parts = \explode('_', $type);

        $className = \implode(\array_map(fn ($part) => \ucfirst(\strtolower($part)), $parts));

        // List is a reserved keyword so change to Collection
        if ($className === 'List') {
            $className = 'Collection';
        }

        $fullClassName = '\PayPro\Entities\\' . $className;

        if (\class_exists($fullClassName)) {
            return $fullClassName;
        } else {
            return '\PayPro\Entities\Entity';
        }
    }

    /**
     * Normalizes the API attributes send by PayPro to be used in the Entity classes.
     *
     * @param array $attributes the attributes
     *
     * @return array
     */
    public static function normalizeApiAttributes($attributes)
    {
        $normalizedAttributes = $attributes;

        if (\array_key_exists('_links', $normalizedAttributes)) {
            $normalizedAttributes['links'] = $normalizedAttributes['_links'];
            unset($normalizedAttributes['_links']);
        }

        unset($normalizedAttributes['type']);

        return $normalizedAttributes;
    }

    /**
     * Creates an Entity from the data send by the PayPro API. It will look at the type attribute
     * and create the correct Entity object.
     *
     * It runs recursively through the data array and parses the value according to the variable
     * type. If no suitable type can be found it will return the variable itself.
     *
     * @param array $data the data from the API response
     * @param ApiClient $client the client to be used by the entity for requests
     * @param array $params the params used for instance for filtering
     *
     * @return Entities\Entity|mixed
     */
    public static function toEntity($data, $client, $params = [])
    {
        if (self::isList($data)) {
            return array_map(fn ($i) => self::toEntity($i, $client), $data);
        } elseif (\is_array($data)) {
            if (\array_key_exists('type', $data)) {
                $entityClass = self::entityClass($data['type']);
                $entity = new $entityClass($data, $client);

                if ($entity instanceof \PayPro\Entities\Collection) {
                    $entity->setFilters($params);
                }

                return $entity;
            } else {
                foreach ($data as $key => $value) {
                    $data[$key] = self::toEntity($value, $client);
                }

                return $data;
            }
        } else {
            return $data;
        }
    }

    /**
     * Checks if the gives array is a list or a dictionary. A list is an array where all values are
     * int and start with 0 and count upwards like: [0, 1, 2, 3]. Anything else will be a dictionary
     * . An empty array will return true.
     *
     * @param array|mixed $array
     *
     * @return bool true if the given param is a list
     */
    public static function isList($array)
    {
        if (!\is_array($array)) {
            return false;
        }

        return $array === [] || (\array_keys($array) === \range(0, \count($array) - 1));
    }

    /**
     * Converts an array of paramters to a query string. Can be used in the query string of an URL or
     * in as the form parameters for POST requests.
     *
     * @param array $params the parameters to be encoded
     *
     * @return string the query string
     */
    public static function encodeParameters($params)
    {
        $parts = [];
        $pieces = [];

        foreach ($params as $key => $value) {
            $pieces[] = self::urlEncode($key) . '=' . self::urlEncode($value);
        }

        return \implode('&', $pieces);
    }

    /**
     * Uses urlencode the encode a value but reverts the brackets '[' and ']' to make the URL look
     * nicer.
     *
     * @param string $value the value to be encoded
     *
     * @return string the encoded value
     */
    public static function urlEncode($value)
    {
        $string = \urlencode((string) $value);
        $string = \str_replace('%5B', '[', $string);

        return \str_replace('%5D', ']', $string);
    }
}
