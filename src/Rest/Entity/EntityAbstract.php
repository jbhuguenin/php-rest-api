<?php
/**
 * Created by PhpStorm.
 * User: jean-baptistehuguenin
 * Date: 15/07/2017
 * Time: 15:12
 */

namespace Rest\Entity;


class EntityAbstract implements \ArrayAccess
{
    /**
     * @param $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        $value  = null;
        $offset = ucfirst($offset);
        if (\method_exists($this, 'get' . $offset)) {
            $value = $this->{"get$offset"}();
        }

        return $value !== null;
    }

    /**
     * @param $offset
     * @param $value
     * @return bool
     */
    public function offsetSet($offset, $value)
    {
        /**
         * Underscore to camelcase if needed
         */
        $offset = lcfirst(implode('', array_map('ucfirst', explode('_', $offset))));

        if (\method_exists($this, 'set' . ucfirst($offset))) {
            return $this->{"set$offset"}($value);
        } else {
            return false;
        }
    }

    /**
     * @param $offset
     * @return bool
     */
    public function offsetGet($offset)
    {
        if (\method_exists($this, 'get' . ucfirst($offset))) {
            return $this->{"get$offset"}();
        } else {
            return false;
        }

    }

    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetUnset($offset)
    {
        return $this->offsetSet($offset, null);
    }

    /**
     * @return array
     */
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }


    /**
     * @param array $array
     * @return EntityAbstract
     */
    public function exchangeArray(array $array)
    {
        return $this->setFromArray($array);
    }

    /**
     * @param $data
     * @return $this
     * @throws \Exception
     */
    public function setFromArray($data)
    {
        if (is_object($data)) {
            if ($data instanceof \ArrayObject) {
                $data = $data->getArrayCopy();
            } elseif (method_exists($data, 'toArray')) {
                $data = $data->toArray();
            } elseif (!$data instanceof \Iterator) {
                throw new \Exception("Model should be instanciated with an array or an Iterable object");
            }
        } elseif (!is_array($data)) {
            throw new \Exception("Model should be instanciated with an array or an Iterable object");
        }

        foreach ($data as $key => $value) {
            $this->offsetSet($key, $value);
        }

        return $this;
    }
}