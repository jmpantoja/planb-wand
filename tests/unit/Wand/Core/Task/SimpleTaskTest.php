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
use PlanB\Wand\Core\File\FileManager;
use PlanB\Wand\Core\Logger\LogManager;
use PlanB\Wand\Core\Task\SimpleTask;
use PlanB\Wand\Core\Task\TaskBuilder;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\Yaml\Yaml;

/**
 * Class TaskManagerTest
 * @package PlanB\Spine\Core\Task
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * @coversDefaultClass \PlanB\Wand\Core\Task\SimpleTask
 */
class SimpleTaskTest extends Unit
{

    /**
     * @test
     *
     * @covers ::execute
     *
     * @covers \PlanB\Wand\Core\Task\Task::run
     * @covers \PlanB\Wand\Core\Task\Task::launch()
     *
     */
    public function testLaunch()
    {

        $logger = $this->mock(LogManager::class, [
            'info' => null
        ]);

        $dispatcher = $this->mock(EventDispatcher::class, [
            'dispatch' => null
        ]);

        $tasks = $this->fromFile('complete');
        $options = $tasks['taskA'];

        $builder = TaskBuilder::create();
        $task = $builder->buildTask($options);

        $task->setEventDispatcher($dispatcher->make());
        $task->setLogger($logger->make());

        $this->assertInstanceOf(SimpleTask::class, $task);

        $task->launch('init');

        $logger->verify('info', 1);

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