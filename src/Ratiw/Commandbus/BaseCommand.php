<?php namespace Ratiw\CommandBus;

use Illuminate\Support\Facades\App;
use InvalidArgumentException;

abstract class BaseCommand
{
    protected $properties = [];

    protected $validator = null;

    function __construct($input)
    {
        if ( ! is_array($input))
        {
            throw new InvalidArgumentException("Argument must be of type array.");
        }

        if (is_array($input) and ! is_null($this->validator))
        {
            App::make($this->validator)->validate($input);
        }

        $this->initializeProperties();

        $this->mapInputToProperties($input);
    }


    /**
     * Get the validator
     *
     * @return null
     */
    public function getValidator()
    {
        return $this->validator;
    }

    /**
     * Set the validator for the command
     *
     * @param CommandValidator $validator
     */
    public function setValidator($validator)
    {
        if ( ! $validator instanceof CommandValidator)
        {
            throw new InvalidArgumentException("[$validator] must be an instance of " . CommandValidator::class);
        }

        $this->validator = $validator;
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
}