<?php

namespace CodesWholesale\Util;


class Magic
{

    /** @var array Hash of methods available to the class (provides fast isset() lookups) */
    private $methods;

    public function __construct()
    {
        $this->methods = array_flip(get_class_methods(get_class($this)));
    }

    /**
     * Magic "get" method
     *
     * @param string $property Property name
     * @return mixed|null Property value if it exists, null if not
     */
    public function __get($property)
    {

        $method = 'get' . ucfirst($property);
        if (isset($this->methods[$method])) {
            return $this->{$method}();
        }

        return null;
    }

    /**
     * Magic "set" method
     *
     * @param string $property Property name
     * @param mixed $value Property value
     */
    public function __set($property, $value)
    {
        $method = 'set' . ucfirst($property);
        if (isset($this->methods[$method])) {
            $this->{$method}($value);
        }
    }
}