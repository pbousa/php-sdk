<?php namespace PboApi\Support;

/**
 * Copyright 2014 Photo Booth Options. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License").
 * You may not use this file except in compliance with the License.
 * A copy of the License is located at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * or in the "license" file accompanying this file. This file is distributed
 * on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either
 * express or implied. See the License for the specific language governing
 * permissions and limitations under the License.
 *
 *
 * @author Bret Mette <bret.mette@rowdydesign.com>
 */

use ArrayAccess;
use ArrayIterator;
use IteratorAggregate;
use PboApi\Services\ClientService;

abstract class AbstractResourceCollection implements ArrayAccess, IteratorAggregate {

    /**
     * @var array
     */
    protected $_items = array();

    /**
     * @var int
     */
    protected $currentPage = 1;

    /**
     * @var int
     */
    protected $lastPage = 1;

    /**
     * @var int
     */
    protected $perPage = 1000;

    /**
     * @var array
     */
    protected $requestParms = array();

    /**
     * @var int
     */
    protected $serverItemCount;

    /**
     * @var \PboApi\Services\ClientService
     */
    protected $clientService;

    /**
     * Initalize the class
     *
     * @param array $items
     */
    public function __construct($items = array())
    {
        $this->_items = $items;

        $this->clientService = new ClientService();
    }

    /**
     * @param array $params
     *
     * @return ResourceCollectionInterface
     */
    public function get(array $params = array())
    {
        $this->_items = array();

        $response = $this->sendRequest('GET', $this->resource, $params);

        if (is_object($response) && property_exists($response, 'success') && $response->success = true) {
            if (property_exists($response, 'data') && is_array($response->data) && count($response->data) > 0) {
                $this->_items = $response->data;
            }

            if (property_exists($response, 'total')) {
                $this->serverItemCount = (int)$response->total;

                if ($this->serverItemCount < 0) {
                    $this->serverItemCount = 0;
                }
            }

            if (property_exists($response, 'current_page')) {
                $this->currentPage = (int)$response->current_page;

                if ($this->currentPage < 1) {
                    $this->currentPage = 1;
                }
            }

            if (property_exists($response, 'last_page')) {
                $this->lastPage = (int)$response->last_page;

                if ($this->lastPage < 1) {
                    $this->lastPage = 1;
                }
            }

            $this->requestParams = $params;
        }

        return $this;
    }

    /**
     * Get resource count
     *
     * @param array $params
     *
     * @return int
     */
    public function count(array $params = array())
    {
        $count = 0;

        $params['exclude_data'] = 'true';
        $this->get($params);

        return $this->serverItemCount;
    }

    /**
     * Get next page of data
     *
     * @return \PboApi\Support\ResourceCollectionInterface
     */
    public function getNext()
    {
        if ($this->lastPage > $this->currentPage) {
            $this->requestParams['page'] = $this->currentPage + 1;

            return $this->get($this->requestParams);
        }


        return null;
    }

    /**
     * @param int $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->_items[] = $value;
        } else {
            $this->_items[$offset] = $value;
        }
    }

    /**
     * @param int $offset
     *
     * @return mixed
     */
    public function offsetExists($offset)
    {
        return isset($this->_items[$offset]);
    }

    /**
     * @param int $offset
     */
    public function offsetUnset($offset)
    {
        unset($this->_items[$offset]);
    }

    /**
     * @param int $offset
     *
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return isset($this->_items[$offset]) ? $this->_items[$offset] : null;
    }

    /**
     * @return Traversable
     */
    public function getIterator()
    {
        return new ArrayIterator($this->_items);
    }

    /**
     * Send API request
     *
     * @param string $type
     * @param string resource
     * @param array $payload
     *
     * @return stdClass
     */
    protected function sendRequest($type, $resource, $payload = array())
    {
        return $this->clientService->sendRequest($type, $resource, $payload);
    }

}
