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
use PlanB\Wand\Core\Context\Context;
use PlanB\Wand\Core\Context\ContextManager;
use PlanB\Wand\Core\Logger\LogManager;
use PlanB\Wand\Core\Path\PathManager;
use PlanB\Wand\Core\Task\Exception\InvalidTypeActionException;
use PlanB\Wand\Core\Task\Task;
use PlanB\Wand\Core\Task\TaskBuilder;
use PlanB\Wand\Core\Task\TaskInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\Yaml\Yaml;

/**
 * Class TaskManagerTest
 * @package PlanB\Spine\Core\Task
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * @coversDefaultClass \PlanB\Wand\Core\Task\Task
 */
class TaskTest extends Unit
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
     * @covers ::create
     * @covers ::getActions
     * @covers ::getDescription
     * @covers ::setEventDispatcher
     * @covers ::setLogger
     *
     */
    public function testCreate()
    {
        $builder = $this->getBuilder();

        $tasks = $builder->getTasks();
        foreach ($tasks as $task) {

            $task->setEventDispatcher($this->stub(EventDispatcher::class));
            $task->setLogger($this->stub(LogManager::class));


            $this->tester->assertInstanceOf(Task::class, $task);
            $this->assertAttributeInstanceOf(EventDispatcher::class, 'dispatcher', $task);
            $this->assertAttributeInstanceOf(LogManager::class, 'logger', $task);

            $this->tester->assertInstanceOf(Task::class, $task);

            $this->assertContainsOnly(ActionInterface::class, $task->getActions());
            $this->tester->assertEquals('wubba lubba dub dub', $task->getDescription());
        }

    }

    /**
     * @test
     *
     * @covers ::exists
     * @covers ::get
     * @covers ::configureActionLevel
     *
     */
    public function testGet()
    {
        $builder = $this->getBuilder();
        $tasks = $builder->getTasks();

        foreach ($tasks as $task) {
            $this->tester->assertInstanceOf(Task::class, $task);

            $this->tester->assertTrue($task->exists('actionA'));
            $this->tester->assertTrue($task->exists('actionB'));
            $this->tester->assertFalse($task->exists('actionXXXX'));

            $actions = $task->getActions();

            foreach (array_keys($actions) as $name) {

                $action = $task->get($name);
                $this->tester->assertInstanceOf(ActionInterface::class, $action);
                $level = 0;

                if ('@taskA' === $name) {
                    $this->tester->assertInstanceOf(TaskInterface::class, $action);
                    $level = 1;
                }

                $this->tester->assertEquals($level, $action->getLevel());
            }

            $this->tester->assertCount(3, $task->getActions());
        }
    }

    /**
     * @test
     *
     * @covers ::file
     *
     * @covers \PlanB\Wand\Core\Task\Exception\InvalidTypeActionException::create
     */
    public function testFile()
    {
        $builder = $this->getBuilder();
        $tasks = $builder->getTasks();

        $task = $tasks['taskA'];

        $task->file('actionA');

        $this->tester->expectException(InvalidTypeActionException::class, function () use ($task) {
            $task->file('actionB');
        });

        $this->tester->expectException(InvalidTypeActionException::class, function () use ($task) {
            $task->file('actionC');
        });

    }


    /**
     * @test
     *
     * @covers ::exists
     * @covers ::get
     *
     * @covers \PlanB\Wand\Core\Task\Exception\ActionMissingException::create()
     *
     * @expectedException \PlanB\Wand\Core\Task\Exception\ActionMissingException
     */
    public function testGetException()
    {
        $builder = $this->getBuilder();

        $tasks = $builder->getTasks();

        foreach ($tasks as $task) {
            $this->tester->assertInstanceOf(Task::class, $task);
            $task->get('actionXXXXXX');
        }
    }

    /**
     * @return TaskBuilder
     */
    protected function getBuilder(): TaskBuilder
    {
        $config = $this->fromFile('complete');
        $logger = $this->stub(LogManager::class);
        $dispatcher = new EventDispatcher();

        $builder = new TaskBuilder($dispatcher, $logger);

        $builder->setConfig($config);

        return $builder;
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