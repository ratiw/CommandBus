<?php namespace Ratiw\CommandBus;

use InvalidArgumentException;

abstract class BaseCommand
{
    protected $properties;

    function __construct($input)
    {
        if ( ! is_array($input))
        {
            throw new InvalidArgumentException("Argument must be of type array.");
        }

        if (is_array($input))
        {
            $this->validate($input);
        }

        $this->initializeProperties();

        $this->mapInputToProperties($input);
    }

    public function __isset($name)
    {
        return array_key_exists($name, $this->properties);
    }

    public function __get($name)
    {
        if (array_key_exists($name, $this->properties))
        {
            return $this->properties[$name];
        }

        throw new InvalidArgumentException("Property $name does not exist.");
    }

    public function __set($name, $value)
    {
        $this->properties[$name] = $value;
    }

    private function initializeProperties()
    {
        $props = [];

        foreach ($this->properties as $key => $value)
        {
            if (is_int($key))
            {
                $key = $value;
                $value = null;
            }

            $props[$key] = $value;
        }

        $this->properties = $props;
    }

    private function mapInputToProperties(array $input)
    {
        foreach ($input as $key => $value)
        {
            array_key_exists($key, $this->properties) and $this->$key = $value;
        }
    }

    public function validate()
    {
        return true;
    }
}