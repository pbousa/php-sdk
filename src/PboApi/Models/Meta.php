<?php namespace PboApi\Models;

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

use PboApi\Support\AbstractResource;
use PboApi\Support\ResourceInterface;
use PboApi\Support\ResourceMetaTrait;

class Meta {

    /**
     * Key
     *
     * @var string
     */
    protected $key;

    /**
     * Value
     *
     * @var string
     */
    protected $value;

    /**
     * Instaniate the object
     *
     * @param  string  $key
     * @param  string  $value
     */
    public function __construct($key = null, $value = null)
    {
        $this->setKey($key);
        $this->setValue($value);
    }

    /**
     * Get key
     *
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Set key
     *
     * @param  string  $key
     */
    public function setKey($key)
    {
        $this->key = $key;
    }

    /**
     * Get value
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set value
     *
     * @param  string  $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

}
