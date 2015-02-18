<?php namespace Ratiw\CommandBus;

use Illuminate\Support\MessageBag;
use Illuminate\Validation\Factory as Validator;
use InvalidArgumentException;

abstract class CommandValidator
{
    protected $rules = [];

    protected $messages = [];

    protected $errors;

    protected $validator;

    function __construct(Validator $validator)
    {
        $this->validator = $validator;
        $this->errors = new MessageBag;
    }

    public function validate(array $input)
    {
        return $this->validateCollection(array($input), $this->rules, $this->messages);
    }

    public function validateCollection(array $collection, $rules, $messages = [])
    {
        foreach ($collection as $item)
        {
            $this->validateEach($item, $rules, $messages);
        }

        if ($this->errors->count() > 0)
        {
            throw new CommandValidationException('Validation failed.', $this->errors);
        }

        return true;
    }

    private function validateEach($item, $rules, $messages)
    {
        $validation = $this->validator->make($item, $rules, $messages);

        if ($validation->fails())
        {
            $this->errors->merge($validation->errors());
        }
    }

    public function getRuleFor($name)
    {
        if ( ! isset($this->rules[$name]))
        {
            throw new InvalidArgumentException("There is no such field [$name].");
        }

        return $this->rules[$name];
    }
}