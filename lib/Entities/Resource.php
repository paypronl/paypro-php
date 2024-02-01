<?php

namespace PayPro\Entities;

/**
 * @property string $id
 */
abstract class Resource extends AbstractEntity
{
    /**
     * Returns the URL of this specific resource
     *
     * @return string
     */
    public function resourceUrl()
    {
        return '/' . $this->resourcePath() . '/' . $this->id;
    }

    /**
     * Returns the path of this specific resource
     *
     * @return string
     */
    abstract public function resourcePath();
}
