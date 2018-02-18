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

use PlanB\Utils\Dev\Tdd\Test\Unit;
use PlanB\Utils\Path\Path;
use PlanB\Wand\Core\Action\ActionInterface;
use PlanB\Wand\Core\Logger\LogManager;
use PlanB\Wand\Core\Path\PathManager;
use PlanB\Wand\Core\Task\Task;
use PlanB\Wand\Core\Task\TaskBuilder;
use PlanB\Wand\Core\Task\TaskInterface;
use PlanB\Wand\Core\Task\TaskManager;
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
        $tasks = $this->fromFile('complete');

        foreach ($tasks as $options) {
            $builder = TaskBuilder::create();
            $task = $builder->buildTask($options);
            $task->setEventDispatcher($this->make(EventDispatcher::class));
            $task->setLogger($this->make(LogManager::class));


            $this->assertInstanceOf(Task::class, $task);
            $this->assertAttributeInstanceOf(EventDispatcher::class, 'dispatcher', $task);
            $this->assertAttributeInstanceOf(LogManager::class, 'logger', $task);

            $this->assertInstanceOf(Task::class, $task);

            $this->assertContainsOnly(ActionInterface::class, $task->getActions());
            $this->assertEquals('wubba lubba dub dub', $task->getDescription());
        }

    }

    /**
     * @test
     *
     * @covers ::exists
     * @covers ::get
     *
     */
    public function testGet()
    {
        $tasks = $this->fromFile('complete');
        $options = $tasks['taskA'];

        $builder = TaskBuilder::create();
        $task = $builder->buildTask($options);

        $this->assertInstanceOf(Task::class, $task);

        $this->assertTrue($task->exists('actionA'));
        $this->assertTrue($task->exists('actionB'));
        $this->assertFalse($task->exists('actionXXXX'));

        $this->assertInstanceOf(ActionInterface::class, $task->get('actionA'));
        $this->assertInstanceOf(ActionInterface::class, $task->get('actionB'));

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
     * @expectedExceptionMessage  La acción 'actionXXXXXX' no está definida (disponibles actionA|actionB)
     */
    public function testGetException()
    {
        $tasks = $this->fromFile('complete');
        $options = $tasks['taskA'];

        $builder = TaskBuilder::create();
        $task = $builder->buildTask($options);
        $this->assertInstanceOf(Task::class, $task);

        $task->get('actionXXXXXX');
    }

    private function fromFile(string $name): array
    {
        $data = ['tasks' => []];
        $path = sprintf('%s/configs/%s.yml', __DIR__, $name);
        if (is_file($path)) {
            $data = Yaml::parseFile($path);
        }

        return $data['tasks'];

    }


}