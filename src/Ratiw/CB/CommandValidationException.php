<?php namespace Ratiw\CommandBus;

class CommandValidationException extends \Exception
{
    protected $errors;
    
    function __construct($message, $errors)
    {
        $this->errors = $errors;
        
        parent::__construct($message);
    }
    
    public function getErrors()
    {
        return $this->errors;
    }
}