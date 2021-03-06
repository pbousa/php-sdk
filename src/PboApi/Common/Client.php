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


namespace PboApi\Common;


use PboApi\Models;
use PboApi\Collections;


class Client {

    /**
     * @var string
     */
    protected $mode;


    /**
     * @var string
     */
    protected $token;


    /**
     * @var string
     */
    protected $url;


    /**
     * @param string $token
     * @param string $url
     */
    public function __construct($token, $mode = 'production', $url = null)
    {
        $this->token = $token;
        $this->mode = $mode;

        if (isset($url)) {

            $this->url = $url;
        } else {

            switch (strtolower($this->mode)) {

                default:
                case 'production':
                    $this->url = 'https://api.photoboothoptions.com/v2/';
                    break;

                case 'sandbox':
                    $this->url = 'https://sandbox.api.photoboothoptions.com/v2/';
                    break;

            }
        }

        /**
         * TODO : Find a better way to handle the token and url
         */
        define('PBOAPI_COMMON_TOKEN', $this->token);
        define('PBOAPI_COMMON_URL', $this->url);
    }


    /**
     * @param string $key
     *
     * @return mixed
     */
    public function __get($key)
    {
        if (substr($key, -1) == 's') {

            $key = '\PboApi\Collections\\' . $key;
        } else {

            $key = '\PboApi\Models\\' . $key;
        }

        if (class_exists($key)) {

            $class = new $key();

            return $class;
        }


        throw new \Exception('\'' . $key . '\' is not a valid resource.');
    }


}
