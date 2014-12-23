<?php

/**
 * Copyright 2014 Photo Booth Options. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License").
 * You may not use this file except in compliance with the License.
 * A copy of the License is located at
 *
 * http://aws.amazon.com/apache2.0
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


interface ResourceInterface {


    /**
     * Creates a resource
     *
     * @param array $attributes
    *
     * @return ResourceInterface
     */
    public function create(array $attributes = array());


    /**
     * Deletes a resource
     *
     * @return bool
     */
    public function delete();


    /**
     * Get a resource
     *
     * @param array $params
     *
     * @return ResourceInterface
     */
    public function get(array $params = array());


    /**
     * Save a resource
     *
     * @return bool
     */
    public function save();


    /**
     * Update a resource
     *
     * @param array $attributes
     *
     * @return bool
     */
    public function update(array $attributes = array());


}
