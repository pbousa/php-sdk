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


namespace PboApi\Models;


use PboApi\Support\AbstractResource;
use PboApi\Support\ResourceInterface;
use PboApi\Support\ResourceMetaTrait;


class User extends AbstractResource implements ResourceInterface {


    use ResourceMetaTrait;


    protected $resource = 'users';


    /**
     * @param \PboApi\Models\User $user1
     * @param \PboApi\Models\User $user2
     *
     * @return User
     */
    public function merge(User $user1, User $user2)
    {
        $response = $this->sendRequest('PUT', 'users/merge', array($user1, $user2));

        if (is_object($response) && property_exists($response, 'success') && $response->success = true) {

            if (property_exists($response, 'data') && is_array($response->data) && count($response->data) > 0 && is_object($response->data[0])) {

                $resource = $response->data[0];

                foreach ($resource as $key=>$value) {

                    $this->_items[$key] = $value;
                }
            }
        }


        return isset($resource) ? $this : null;
    }


}
