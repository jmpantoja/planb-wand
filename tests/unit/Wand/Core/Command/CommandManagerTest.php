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
use PlanB\Wand\Core\Logger\Message\LogMessage;

/**
 * Class CommandText
 * @package PlanB\Wand\Core\Command
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * @coversDefaultClass  \PlanB\Wand\Core\Command\CommandManager
 */
class CommandManagerTest extends Unit
{
    use Mocker;

    /**
     * @var \UnitTester
     */
    protected $tester;


    /**
     * @test
     *
     * @covers ::getSubscribedEvents
     */
    public function testSubscribedEvents()
    {

        $this->tester->assertEquals([
            'wand.cmd.execute' => 'execute'
        ], CommandManager::getSubscribedEvents());
    }

    /**
     * @test
     *
     * @covers ::execute
     */
    public function testExecute()
    {
        $manager = new CommandManager();
        $event = $this->getEvent(true);

        $manager->execute($event);

        $lines = $event->getMessage()->parseVerbose();

        $this->tester->assertTrue($event->getMessage()->isSuccessful());
        $this->tester->assertContains('titulo', $lines[0]);
        $this->tester->assertContains('command line', $lines[1]);
    }

    /**
     * @test
     *
     * @covers ::execute
     */
    public function testExecuteFail()
    {
        $manager = new CommandManager();
        $event = $this->getEvent(false);

        $manager->execute($event);

        $lines = $event->getMessage()->parseVerbose();

        $this->tester->assertTrue($event->getMessage()->isError());
        $this->tester->assertContains('titulo', $lines[0]);
        $this->tester->assertContains('command line', $lines[1]);
    }


    private function getEvent($success): CommandEvent
    {

        $command = $this->stub(Command::class, [
            'getTitle' => 'titulo',
            'getCommandLine' => 'command line',
            'run' => $success
        ]);

        return new CommandEvent($command);
    }


}