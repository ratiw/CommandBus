<?php namespace Ratiw\CommandBus;

use App;

trait CommandBusTrait 
{
    /**
     * Execute the command.
     * 
     * @param $command
     * @return mixed
     */
    protected function execute($command)
    {
        $bus = $this->getCommandBus();

        return $bus->execute($command);
    }

    /**
     * Fetch the command bus
     *
     * @return mixed
     */
    public function getCommandBus()
    {
        return App::make('Ratiw\CommandBus\CommandBus');
    }
}
