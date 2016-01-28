<?php namespace PboApi\Common;

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

use PboApi\Models;
use PboApi\Collections;
use PboApi\Factories\ResourceFactory;

class Client {

    /**
     * @var string
     */
    protected $mode;

    /**
     * @var string
     */
    protected static $token;

    /**
     * @var string
     */
    protected static $url;

    /**
     * @param string $token
     * @param string $url
     */
    public function __construct($token, $mode = 'production', $url = null)
    {
        self::$token = $token;
        $this->mode = $mode;

        if (isset($url)) {
            self::$url = $url;
        } else {
            switch (strtolower($this->mode)) {
                default:
                case 'production':
                    self::$url = 'https://api.photoboothoptions.com/v2.1.0/';
                    break;

                case 'sandbox':
                    self::$url = 'https://sandbox.api.photoboothoptions.com/v2.1.0/';
                    break;
            }
        }
    }

    /**
     * @param string $key
     *
     * @return mixed
     */
    public function __get($key)
    {
        return ResourceFactory::make($key);
    }

    /**
     * Get token
     *
     * @return string
     */
    public static function getToken()
    {
        return self::$token;
    }

    /**
     * Get url
     *
     * @return string
     */
    public static function getUrl()
    {
        return self::$url;
    }

}
