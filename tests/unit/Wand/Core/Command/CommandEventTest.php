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
use PlanB\Wand\Core\Logger\Message\MessageType;

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

        $command = $this->getCommand();
        $event = new CommandEvent($command);

        $this->tester->assertEquals($command, $event->getCommand());
        $this->tester->assertEquals('wand.cmd.execute', $event->getName());

        $message = LogMessage::success();
        $event->configureLog($message);

        $lines = $message->parseVerbose();
        $this->tester->assertContains('Execute command', $lines[0]);


        $message = LogMessage::skip();
        $event->configureLog($message);

        $lines = $message->parseVerbose();
        $this->tester->assertContains('Execute command', $lines[0]);

    }

    /**
     * @test
     *
     * @covers ::type
     */
    public function testType()
    {

        $command = $this->getCommand();
        $event = new CommandEvent($command);

        $event->type(MessageType::SUCCESS());
        $this->assertTrue($event->getMessage()->isSuccessful());

        $event->type(MessageType::SKIP());
        $this->assertTrue($event->getMessage()->isSkipped());


        $event->type(MessageType::ERROR());
        $this->assertTrue($event->getMessage()->isError());

    }

    /**
     * @return Command
     */
    protected function getCommand(): Command
    {
        $context = $this->stub(Context::class);
        $context->allows()
            ->getPath('vendor/bin')
            ->andReturn(Path::join(realpath('.'), 'vendor/bin'));

        $context->allows()
            ->getPath('src')
            ->andReturn(Path::join(realpath('.'), 'src'));

        $context->allows()
            ->getPath('project')
            ->andReturn(realpath('.'));

        $context->allows()
            ->getPath('target')
            ->andReturn(realpath('.'));

        $context->allows()
            ->getPath('wand')
            ->andReturn(realpath('.'));

        $command = SystemCommand::create([
            'group' => 'metainfo',
            'params' => [
                'pattern' => 'command -la %target%'
            ]
        ]);

        $command->setContext($context);
        return $command;
    }
}