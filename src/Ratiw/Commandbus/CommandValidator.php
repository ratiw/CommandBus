<?php namespace Ratiw\CommandBus;

use Illuminate\Validation\Factory as Validator;

abstract class CommandValidator
{
    protected $rules = [];

    protected $messages = [];

    protected $validator;

    function __construct(Validator $validator)
    {
        $this->validator = $validator;
    }

    public function validate(array $input)
    {
        $validation = $this->validator->make($input, $this->rules, $this->messages);

        if ($validation->fails())
        {
            throw new CommandValidationException('Validation failed', $validation->errors());
        }

        return true;
    }
}