<?php namespace Ratiw\CommandBus;

interface CommandBus {

    /**
     * Execute a command
     *
     * @param $command
     * @return mixed
     */
    public function execute($command);

}