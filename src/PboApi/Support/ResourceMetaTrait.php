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

trait ResourceMetaTrait {

    /**
     * @param string $key;
     *
     * @return string
     */
    public function getMeta($key)
    {
        $meta = null;

        foreach ($this->_attributes['metas'] as $r_meta) {
            if ($r_meta->getKey() == $key) {
                $meta = $r_meta;
            }
        }

        return $meta;
    }

    /**
     * @param mixed $metaOrKey
     * @param string $value
     *
     * @return ResourceInterface
     */
    public function setMeta($metaOrKey, $value = null)
    {
        if (is_object($metaOrKey) && is_a('\PboApi\Models\Meta')) {
            $meta = $metaOrKey;
        } else {
            $meta = new \PboApi\Models\Meta($key, $value);
        }

        $exists = false;

        foreach ($this->_attributes['metas'] as &$r_meta) {
            if ($r_meta->getKey() == $meta->getKey()) {
                $r_meta = $meta;
                $exists = true;
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
                if (stripos($meta->getKey(), $group . '.') === 0) {
                    $metas[] = $meta;
                }
            } else {
                $metas[] = $meta;
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
            $this->setMeta($meta);
        }

        return $this;
    }

}
