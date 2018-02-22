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
use PlanB\Wand\Core\Action\ActionInterface;
use PlanB\Wand\Core\Path\PathManager;
use PlanB\Wand\Core\Task\Task;
use PlanB\Wand\Core\Task\TaskBuilder;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Yaml\Yaml;

/**
 * Class TaskManagerTest
 * @package PlanB\Spine\Core\Task
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * @coversDefaultClass \PlanB\Wand\Core\Task\TaskBuilder
 */
class TaskBuilderTest extends Unit
{

    /**
     * @test
     *
     * @covers ::__construct
     * @covers ::setContainer
     *
     * @covers ::buildTask
     * @covers ::resolveActions
     * @covers ::buildAction
     */
    public function create()
    {
        $tasks = $this->fromFile('complete');

        $pathManager = $this->make(PathManager::class, [
            'projectDir' => realpath('.')
        ]);

        $container = new ContainerBuilder();
        $container->set('wand.path.manager', $pathManager);

        foreach ($tasks as $options) {

            $builder = new TaskBuilder($container);
            $task = $builder->buildTask($options);
            $this->assertInstanceOf(Task::class, $task);

            $this->assertContainsOnly(ActionInterface::class, $task->getActions());
        }

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