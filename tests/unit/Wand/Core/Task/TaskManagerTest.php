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
use PlanB\Wand\Core\Action\ActionRunner;
use PlanB\Wand\Core\Config\ConfigManager;
use PlanB\Wand\Core\Path\PathManager;
use PlanB\Wand\Core\Task\Task;
use PlanB\Wand\Core\Task\TaskBuilder;
use PlanB\Wand\Core\Task\TaskInterface;
use PlanB\Wand\Core\Task\TaskManager;
use Symfony\Component\Yaml\Yaml;

/**
 * Class TaskManagerTest
 * @package PlanB\Spine\Core\Task
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * @coversDefaultClass \PlanB\Wand\Core\Task\TaskManager
 */
class TaskManagerTest extends Unit
{

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

        $this->assertTrue($manager->exists('taskA'));
        $this->assertTrue($manager->exists('taskB'));
        $this->assertFalse($manager->exists('taskXXX'));

    }


    /**
     * @test
     *
     * @covers ::__construct
     * @covers ::get
     * @covers ::exists
     */
    public function testGetTask()
    {
        $manager = $this->getTaskManager();

        $task = $manager->get('taskA');
        $this->assertInstanceOf(TaskInterface::class, $task);

        $this->assertContainsOnly(ActionInterface::class, $task->getActions());
        $this->assertCount(2, $task->getActions());

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

    private function fromFile(string $name): array
    {
        $data = ['tasks' => []];
        $path = sprintf('%s/configs/%s.yml', __DIR__, $name);
        if (is_file($path)) {
            $data = Yaml::parseFile($path);
        }

        return $data['tasks'];

    }

    private function getTaskManager(): TaskManager
    {
        $tasks = $this->fromFile('complete');

        $builder = $this->make(TaskBuilder::class, [
            'buildTask' => $this->make(Task::class, [
                'getActions' => [
                    $this->make(ActionInterface::class),
                    $this->make(ActionInterface::class)
                ]
            ])
        ]);

        $config = $this->make(ConfigManager::class, [
            'getTasks' => $tasks
        ]);

        return new TaskManager($config, $builder);
    }

}