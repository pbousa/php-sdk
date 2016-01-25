<?php

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


namespace PboApi\Support;


use ICanBoogie\Inflector;
use PboApi\Services\ClientService;


abstract class AbstractResource {


    /**
     * @var array
     */
    protected $_attributes = array();


    /**
     * @var \PboApi\Services\ClientService
     */
    protected $clientService;


    /**
     * @var string
     */
    protected $resource;


    /**
     * @var string
     */
    protected $primaryKey = 'uuid';


    /**
     * Initialize the class
     */
    public function __construct()
    {
        $this->clientService = new ClientService();
    }


    /**
     * @param string $name
     * @param array $arguments
     */
    public function __call($name, $arguments)
    {
        $inflector = Inflector::get();

        /**
         * Get a resource attribute
         */
        if (strtolower(substr($name, 0, 3)) == 'get' && count($arguments) === 0) {
            $key = str_replace('get', '', $name);
            $key = $inflector->underscore($key);

            if (isset($this->_attributes) && is_array($this->_attributes) && array_key_exists($key, $this->_attributes)) {
                return $this->_attributes[$key];
            }
        }


        /**
         * Set a resource attribute
         */
        if (strtolower(substr($name, 0, 3)) == 'set' && count($arguments) === 1) {

            $key = str_replace('set', '', $name);
            $key = $inflector->underscore($key);

            if (isset($this->_attributes) && is_array($this->_attributes) && array_key_exists($key, $this->_attributes)) {
                $this->_attributes[$key] = $arguments[0];
            }
        }
    }

    /**
     * Creates a resource
     *
     * @param array $attributes
     *
     * @return ResourceInterface
     */
    public function create(array $attributes = array())
    {
        $resource = null;

        $response = $this->sendRequest('POST', $this->resource, $attributes);

        if (is_object($response) && property_exists($response, 'success') && $response->success == 'true') {
            if (property_exists($response, 'data') && is_array($response->data) && count($response->data)) {
                if (is_object($response->data[0]) && property_exists($response->data[0], 'resource') && is_object($response->data[0]->resource)) {
                    $resource = $response->data->resource;

                    foreach ($resource as $key=>$value) {
                        $this->_attributes[$key] = $value;
                    }
                }
            }
        }

        return isset($resource) ? $this : null;
    }


    /**
     * Deletes a resource
     *
     * @return bool
     */
    public function delete()
    {
        $success = false;

        $response = $this->sendRequest('DELETE', $this->resource, array($this->primaryKey => call_user_func(array($this, 'get' . $this->primaryKey))));

        if (is_object($response) && property_exists($response, 'success') && $response->success = true) {
            $success = true;
        }

        return $success;
    }

    /**
     * Get a resource
     *
     * @param array $params
     *
     * @return ResourceInterface
     */
    public function get(array $params = array())
    {
        $resource = null;

        $response = $this->sendRequest('GET', $this->resource, $params);

        if (is_object($response) && property_exists($response, 'data') && is_array($response->data) && count($response->data) > 0 && is_object($response->data[0])) {
            $resource = $response->data[0];

            foreach ($resource as $key=>$value) {
                $this->_attributes[$key] = $value;
            }
        }

        return isset($resource) ? $this : null;
    }

    /**
     * Save a resource
     *
     * @return bool
     */
    public function save()
    {
        return $this->update($this->_attributes);
    }

    /**
     * Update a resource
     *
     * @param array $attributes
     *
     * @return bool
     */
    public function update(array $attributes = array())
    {
        $success = false;

        if (!array_key_exists($this->primaryKey, $attributes) || (array_key_exists($this->primaryKey, $attributes) && strlen($attributes[$this->primaryKey]) <= 0)) {
            $attributes[$this->primaryKey] = call_user_func(array($this, 'get' . $this->primaryKey));
        }

        $response = $this->sendRequest('PUT', $this->resource, $attributes);

        if (is_object($response) && property_exists($response, 'success') && $response->success = true) {
            $success = true;
        }

        return $success;
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

