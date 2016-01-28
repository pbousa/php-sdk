<?php namespace PboApi\Factories;

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

class ResourceFactory {

    public static function make($key)
    {
        if (substr($key, -1) === 's') {
            $key = '\PboApi\Collections\\' . ucfirst($key);
        } else {
            $key = '\PboApi\Models\\' . ucfirst($key);
        }

        if (class_exists($key)) {
            $class = new $key();

            return $class;
        }

        throw new \Exception('\'' . $key . '\' is not a valid resource.');
    }

    public static function makeFromJsonObject($jsonObject, $key)
    {
        if (substr($key, -1) === 's') {
            $key = substr($key, 0, -1);
        }

        $resource = self::make($key);

        if (method_exists($resource, 'deserializeJson')) {
            $resource->deserializeJson(json_encode($jsonObject));
        }

        return $resource;
    }

}
