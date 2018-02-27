<?php
/**
 * This file is part of the planb project.
 *
 * (c) Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace PlanB\Wand\Core\Command;


use Codeception\Test\Unit;
use PlanB\Utils\Dev\Tdd\Feature\Mocker;
use PlanB\Utils\Path\Path;
use PlanB\Wand\Core\Context\Context;
use PlanB\Wand\Core\Logger\Message\LogMessage;

/**
 * Class CommandText
 * @package PlanB\Wand\Core\Command
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * @coversDefaultClass  \PlanB\Wand\Core\Command\CommandEvent
 */
class CommandEventTest extends Unit
{
    use Mocker;

    /**
     * @var \UnitTester
     */
    protected $tester;


    /**
     * @test
     *
     * @covers ::__construct
     *
     * @covers ::configureLog
     * @covers ::getCommand
     * @covers ::getName
     */
    public function testCreate()
    {

        $context = $this->stub(Context::class);
        $context->allows()
            ->getPath('vendor/bin')
            ->andReturn(Path::join(realpath('.'), 'vendor/bin'));

        $context->allows()
            ->getPath('project')
            ->andReturn(realpath('.'));

        $context->allows()
            ->getPath('target')
            ->andReturn(realpath('.'));


        $command = Command::create([
            'group' => 'metainfo',
            'params' => [
                'pattern' => 'command -la %target%',
                'cwd' => 'vendor/bin'
            ]
        ]);

        $command->setContext($context);

        $event = new CommandEvent($command);

        $this->tester->assertEquals($command, $event->getCommand());
        $this->tester->assertEquals('wand.cmd.execute', $event->getName());


        $message = LogMessage::success();
        $event->configureLog($message);

        $lines = $message->parseVerbose();

        $this->tester->assertContains('vendor/bin/command -la', $lines[0]);

    }
}