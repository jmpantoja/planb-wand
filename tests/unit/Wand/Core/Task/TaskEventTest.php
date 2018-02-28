<?php
/**
 * This file is part of the planb project.
 *
 * (c) Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace PlanB\Spine\Core\Task;

use Codeception\Test\Unit;
use PlanB\Utils\Dev\Tdd\Feature\Mocker;
use PlanB\Wand\Core\Logger\Message\LogMessage;
use PlanB\Wand\Core\Task\Task;
use PlanB\Wand\Core\Task\TaskEvent;
use \Mockery as m;


/**
 * Class TaskManagerTest
 * @package PlanB\Spine\Core\Task
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * @coversDefaultClass \PlanB\Wand\Core\Task\TaskEvent
 */
class TaskEventTest extends Unit
{

    use Mocker;

    /**
     * @var  \UnitTester $tester
     */
    protected $tester;


    /**
     * @test
     *
     * @covers ::__construct
     * @covers ::getTask
     * @covers ::getName
     * @covers ::configureLog
     */
    public function testEvent()
    {
        $task = $this->stub(Task::class);
        $event = new TaskEvent($task);

        $this->assertAttributeEquals($task, 'task', $event);

        $this->assertEquals($task, $event->getTask());
        $this->assertEquals('wand.task.execute', $event->getName());

        $message = $this->double(LogMessage::class);

        $event->configureLog($message->make());

        $message->verifyNeverInvoked('setTitle');
        $message->verifyNeverInvoked('setLevel');
        $message->verifyNeverInvoked('setVerbose');

    }
}