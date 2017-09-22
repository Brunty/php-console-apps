<?php declare(strict_types=1);

namespace App\Properties;

class PropertySetter
{
    /**
     * MAGIC
     *
     * This little function allows us to set private properties on an object.
     *
     * @param object $obj The Object you wish to set the property on
     * @param string $property The property you wish to set
     * @param mixed $value The value to set that property to
     *
     * @return object
     */
    public static function set($obj, string $property, $value)
    {
        $fn = function () use ($property, $value) {
            $this->{$property} = $value;
        };

        $fn->call($obj);

        return $obj;
    }
}
