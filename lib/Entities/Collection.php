<?php

namespace PayPro\Entities;

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
    use \PayPro\Operations\Request;

    /** @var array */
    private $filters = [];

    /**
     * Sets the filters
     *
     * @param array $filters
     */
    public function setFilters($filters)
    {
        $this->filters = $filters;
    }

    /**
     * Gets the filters
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
     * Returns the next page in the resource list if possible
     *
     * @param array $params
     *
     * @throws \PayPro\Exception\ApiErrorException if the api call fails
     *
     * @return \PayPro\Entities\Collection<\PayPro\Entities\AbstractEntity>
     */
    public function next($params = [])
    {
        if ($this->nextLink() === null) {
            return new self(['data' => []]);
        } else {
            $params = array_merge($this->filters, $params, ['cursor' => $this->nextCursorId()]);
            return $this->apiRequest('get', $this->nextUri()['path'], $params);
        }
    }

    /**
     * Returns the previous page in the resource list if possible
     *
     * @param array $params
     *
     * @throws \PayPro\Exception\ApiErrorException if the api call fails
     *
     * @return \PayPro\Entities\Collection<\PayPro\Entities\AbstractEntity>
     */
    public function previous($params = [])
    {
        if ($this->previousLink() === null) {
            return new self(['data' => []]);
        } else {
            $params = array_merge($this->filters, $params, ['cursor' => $this->previousCursorId()]);
            return $this->apiRequest('get', $this->previousUri()['path'], $params);
        }
    }

    /**
     * Returns the first entry of the list
     *
     * @return null|mixed
     */
    public function first()
    {
        return $this->count() !== 0 ? $this->data[0] : null;
    }

    /**
     * Returns the last entry of the list
     *
     * @return null|mixed
     */
    public function last()
    {
        return $this->count() !== 0 ? $this->data[$this->count() - 1] : null;
    }

    /**
     * Returns the next link of this list
     *
     * @return null|string
     */
    private function nextLink()
    {
        if (\array_key_exists('next', $this->links)) {
            return $this->links['next'];
        } else {
            return null;
        }
    }

    /**
     * Returns the uri parts of the next link
     *
     * @return null|array
     */
    private function nextUri()
    {
        if ($this->nextLink() === null) {
            return null;
        } else {
            return \parse_url($this->nextLink());
        }
    }

    /**
     * Returns the cursor id of the next link
     *
     * @return null|string
     */
    private function nextCursorId()
    {
        if ($this->nextUri() === null) {
            return null;
        } else {
            \parse_str($this->nextUri()['query'], $output);
            return $output['cursor'];
        }
    }

    /**
     * Returns the previous link of this list
     *
     * @return null|string
     */
    private function previousLink()
    {
        if (\array_key_exists('prev', $this->links)) {
            return $this->links['prev'];
        } else {
            return null;
        }
    }

    /**
     * Returns the uri parts of the previous link
     *
     * @return null|array
     */
    private function previousUri()
    {
        if ($this->previousLink() === null) {
            return null;
        } else {
            return \parse_url($this->previousLink());
        }
    }

    /**
     * Returns the cursor id of the previous link
     *
     * @return null|string
     */
    private function previousCursorId()
    {
        if ($this->previousUri() === null) {
            return null;
        } else {
            \parse_str($this->previousUri()['query'], $output);
            return $output['cursor'];
        }
    }
}
