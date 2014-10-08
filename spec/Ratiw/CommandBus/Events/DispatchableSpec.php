<?php namespace spec\Ratiw\CommandBus\Events;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Ratiw\CommandBus\Events\Contracts\Dispatcher;

class DispatchableSpec extends ObjectBehavior
{
    function let()
    {
        $this->beAnInstanceOf(HandlerStub::class);
    }

    function it_dispatches_stuff(Dispatcher $dispatcher)
    {
        $this->setDispatcher($dispatcher);

        $this->dispatchEventsFor(new EntityStub);

        $dispatcher->dispatch([])->shouldBeCalled();
    }
}

class HandlerStub {
    use \Ratiw\CommandBus\Events\DispatchableTrait;
}

class EntityStub {
    public function releaseEvents()
    {
        return [];
    }
}