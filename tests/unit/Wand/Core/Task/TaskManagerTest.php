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
use PlanB\Wand\Core\Action\ActionInterface;
use PlanB\Wand\Core\Action\ActionRunner;
use PlanB\Wand\Core\Config\ConfigManager;
use PlanB\Wand\Core\Context\Context;
use PlanB\Wand\Core\Context\ContextManager;
use PlanB\Wand\Core\Logger\LogManager;
use PlanB\Wand\Core\Task\Task;
use PlanB\Wand\Core\Task\TaskBuilder;
use PlanB\Wand\Core\Task\TaskEvent;
use PlanB\Wand\Core\Task\TaskInterface;
use PlanB\Wand\Core\Task\TaskManager;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\Yaml\Yaml;
use Mockery as m;

/**
 * Class TaskManagerTest
 * @package PlanB\Spine\Core\Task
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * @coversDefaultClass \PlanB\Wand\Core\Task\TaskManager
 */
class TaskManagerTest extends Unit
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
     * @covers ::setTasks
     * @covers ::addTask
     * @covers ::exists
     */
    public function testSetTasks()
    {
        $manager = $this->getTaskManager();

        $this->tester->assertTrue($manager->exists('taskA'));
        $this->tester->assertTrue($manager->exists('taskB'));
        $this->tester->assertFalse($manager->exists('taskXXX'));

    }


    /**
     * @test
     *
     * @covers ::__construct
     * @covers ::get
     * @covers ::getContext
     *
     * @covers ::exists
     */
    public function testGetTask()
    {
        $manager = $this->getTaskManager();

        $task = $manager->get('taskA');
        $this->tester->assertInstanceOf(TaskInterface::class, $task);

        $this->assertContainsOnly(ActionInterface::class, $task->getActions());
        $this->tester->assertCount(3, $task->getActions());

    }


    /**
     * @test
     *
     * @covers ::__construct
     * @covers ::get
     * @covers ::exists
     *
     * @covers \PlanB\Wand\Core\Task\Exception\TaskMissingException::create()
     *
     * @expectedException \PlanB\Wand\Core\Task\Exception\TaskMissingException
     * @expectedExceptionMessage La tarea 'taskXXX' no está definida (disponibles taskA|taskB)
     */
    public function testGetTaskException()
    {
        $manager = $this->getTaskManager();

        $manager->get('taskXXX');

    }


    /**
     * @test
     *
     * @covers ::__construct
     * @covers ::execute
     */
    public function testExecute()
    {
        $manager = $this->getTaskManager();

        $task = $this->stub(Task::class);
        $task->allows()
            ->launch()
            ->once();

        $event = $this->stub(TaskEvent::class, [
            'getTask' => $task
        ]);

        $event->allows()
            ->blank(m::any())
            ->once();

        $manager->execute($event);

    }


    /**
     * @test
     *
     * @covers ::__construct
     * @covers ::executeByName
     */
    public function testExecuteByName()
    {
        $manager = $this->getTaskManager();

        $task = $this->stub(Task::class);


        $task->allows()
            ->launch()
            ->once();

        $event = $this->stub(TaskEvent::class, [
            'getTask' => $task
        ]);

        $event->allows()
            ->blank(m::any());

        $manager->executeByName('taskA');
    }


    public function testSubscribedEvents()
    {
        $this->tester->assertEquals([
            'wand.task.execute' => 'execute'
        ], TaskManager::getSubscribedEvents());
    }

    private function getTaskManager(): TaskManager
    {
        $context = $this->stub(ContextManager::class, [
            'getContext' => $this->stub(Context::class)
        ]);

        $logger = $this->stub(LogManager::class);
        $dispatcher = new EventDispatcher();

        $builder = new TaskBuilder($dispatcher, $logger);

        $config = $this->stub(ConfigManager::class, [
            'getConfig' => $this->fromFile('complete')
        ]);

        return new TaskManager($config, $context, $builder);
    }

    private function fromFile(string $name): array
    {
        $data = ['tasks' => [], 'actions' => []];
        $path = sprintf('%s/configs/%s.yml', __DIR__, $name);
        if (is_file($path)) {
            $data = Yaml::parseFile($path);
        }

        return $data;
    }

}