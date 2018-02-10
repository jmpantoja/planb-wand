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
     * @covers ::setTasks
     */
    public function testSetTasks()
    {
        $tasks = $this->fromFile('complete');

        $builder = $this->make(TaskBuilder::class, [
            'buildTask' => $this->make(TaskInterface::class)
        ]);

        $manager = new TaskManager();
        $response = $manager->setTasks($tasks);

        $this->assertInstanceOf(TaskManager::class, $response);

    }


    /**
     * @test
     *
     * @covers ::run
     */
    public function testRun()
    {
        $tasks = $this->fromFile('complete');


        $manager = new TaskManager();
        $manager->setTasks($tasks);

        $manager->run('taskA', false);

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