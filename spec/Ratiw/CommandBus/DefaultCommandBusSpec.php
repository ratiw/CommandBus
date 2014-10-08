<?php

namespace spec\CommandBus;

use CommandBus\CommandTranslator;
use Illuminate\Foundation\Application;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DefaultCommandBusSpec extends ObjectBehavior
{
    function let(Application $app, CommandTranslator $translator)
    {
        $this->beConstructedWith($app, $translator);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('CommandBus\DefaultCommandBus');
    }

    function it_handles_a_command(Application $app, CommandStub $command, CommandTranslator $translator, CommandHandlerStub $handler)
    {
        $translator->toCommandHandler($command)->willReturn('CommandHandler');
        $app->make('CommandHandler')->willReturn($handler);
        $handler->handle($command)->shouldBeCalled();

        $this->execute($command);
    }

}

// Stub Stuff
class CommandStub {}
class CommandHandlerStub { public function handle($command) {} }

namespace Illuminate\Foundation;
class Application { function make() {} }
