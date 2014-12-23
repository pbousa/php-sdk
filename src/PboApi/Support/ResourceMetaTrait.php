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


trait ResourceMetaTrait {


    /**
     * @param string $key;
     *
     * @return string
     */
    public function getMeta($key)
    {
        foreach ($this->_attributes['metas'] as $meta) {

            if ($meta->key == $key) {

                return $meta;
            }
        }


        return null;
    }


    /**
     * @param string $key
     * @param string $value
     *
     * @return ResourceInterface
     */
    public function setMeta($key, $value)
    {
        $meta = new \stdClass();
        $meta->key = $key;
        $meta->value = $value;

        $exists = false;

        foreach ($this->_attributes['metas'] as &$r_meta) {

            if ($r_meta->key == $meta->key) {

                $exists = true;
                $r_meta = $meta;
            }
        }

        if (!$exists) {

            $this->_attributes['metas'][] = $meta;
        }


        return $this;
    }


    /**
     * @param string $group
     *
     * @return array
     */
    public function getMetas($group = '')
    {
        $metas = array();

        foreach ($this->_attributes['metas'] as $meta) {

            if (strlen($group)) {

                if (stripos($meta->key, $group . '.') === 0) {

                    $metas[str_ireplace($group . '.', '', $meta->key)] = $meta->value;
                }
            } else {

                $metas[$meta->key] = $value;
            }
        }

        return $metas;
    }


    /**
     * @param array $metas
     *
     * @return ResourceInterface
     */
    public function setMetas(array $metas = array())
    {
        foreach ($metas as $meta) {

            $this->setMeta($meta->key, $meta->value);
        }


        return $this;
    }


}
