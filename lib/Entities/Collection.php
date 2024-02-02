<?php

namespace PayPro\Entities;

use PayPro\Exception\ApiErrorException;
use PayPro\Operations\Request;

/**
 * Class Collection.
 *
 * @template TEntity of AbstractEntity
 *
 * @property null|array $links
 * @property TEntity[] $data
 */
class Collection extends AbstractEntity implements \Countable, \IteratorAggregate
{
    use Request;

    /** @var array */
    private $filters = [];

    /**
     * Sets the filters.
     *
     * @param array $filters
     */
    public function setFilters($filters)
    {
        $this->filters = $filters;
    }

    /**
     * Gets the filters.
     *
     * @return array
     */
    public function getFilters()
    {
        return $this->filters;
    }

    /**
     * @return int
     */
    #[\ReturnTypeWillChange]
    public function count()
    {
        return \count($this->data);
    }

    /**
     * @return \ArrayIterator
     */
    #[\ReturnTypeWillChange]
    public function getIterator()
    {
        return new \ArrayIterator($this->data);
    }

    /**
     * Returns the next page in the resource list if possible.
     *
     * @param array $params
     *
     * @return \PayPro\Entities\Collection<\PayPro\Entities\AbstractEntity>
     *
     * @throws ApiErrorException if the api call fails
     */
    public function next($params = [])
    {
        if (null === $this->nextLink()) {
            return new self(['data' => []]);
        }
        $params = array_merge($this->filters, $params, ['cursor' => $this->nextCursorId()]);

        return $this->apiRequest('get', $this->nextUri()['path'], $params);
    }

    /**
     * Returns the previous page in the resource list if possible.
     *
     * @param array $params
     *
     * @return \PayPro\Entities\Collection<\PayPro\Entities\AbstractEntity>
     *
     * @throws ApiErrorException if the api call fails
     */
    public function previous($params = [])
    {
        if (null === $this->previousLink()) {
            return new self(['data' => []]);
        }
        $params = array_merge($this->filters, $params, ['cursor' => $this->previousCursorId()]);

        return $this->apiRequest('get', $this->previousUri()['path'], $params);
    }

    /**
     * Returns the first entry of the list.
     *
     * @return null|mixed
     */
    public function first()
    {
        return 0 !== $this->count() ? $this->data[0] : null;
    }

    /**
     * Returns the last entry of the list.
     *
     * @return null|mixed
     */
    public function last()
    {
        return 0 !== $this->count() ? $this->data[$this->count() - 1] : null;
    }

    /**
     * Returns the next link of this list.
     *
     * @return null|string
     */
    private function nextLink()
    {
        if (\array_key_exists('next', $this->links)) {
            return $this->links['next'];
        }

        return null;
    }

    /**
     * Returns the uri parts of the next link.
     *
     * @return null|array
     */
    private function nextUri()
    {
        if (null === $this->nextLink()) {
            return null;
        }

        return \parse_url($this->nextLink());
    }

    /**
     * Returns the cursor id of the next link.
     *
     * @return null|string
     */
    private function nextCursorId()
    {
        if (null === $this->nextUri()) {
            return null;
        }
        \parse_str($this->nextUri()['query'], $output);

        return $output['cursor'];
    }

    /**
     * Returns the previous link of this list.
     *
     * @return null|string
     */
    private function previousLink()
    {
        if (\array_key_exists('prev', $this->links)) {
            return $this->links['prev'];
        }

        return null;
    }

    /**
     * Returns the uri parts of the previous link.
     *
     * @return null|array
     */
    private function previousUri()
    {
        if (null === $this->previousLink()) {
            return null;
        }

        return \parse_url($this->previousLink());
    }

    /**
     * Returns the cursor id of the previous link.
     *
     * @return null|string
     */
    private function previousCursorId()
    {
        if (null === $this->previousUri()) {
            return null;
        }
        \parse_str($this->previousUri()['query'], $output);

        return $output['cursor'];
    }
}
