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
use PlanB\Wand\Core\Action\ActionEvent;
use PlanB\Wand\Core\File\FileManager;
use PlanB\Wand\Core\Logger\LogManager;
use PlanB\Wand\Core\Path\PathManager;
use PlanB\Wand\Core\Task\SimpleTask;
use PlanB\Wand\Core\Task\TaskBuilder;
use Symfony\Component\DependencyInjection\ContainerBuilder;
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
     * @covers \PlanB\Wand\Core\Task\Task::launch
     * @covers \PlanB\Wand\Core\Task\Task::getEvent
     * @covers \PlanB\Wand\Core\Task\Task::setName
     * @covers \PlanB\Wand\Core\Task\Task::validateContext
     *
     */
    public function testLaunch()
    {

        $logger = $this->mock(LogManager::class, [
            'info' => null,
            'log' => null
        ]);

        $task = $this->getTask($logger, true);

        $this->assertInstanceOf(SimpleTask::class, $task);

        $task->setName('init');
        $task->launch();

        $logger->verify('info', 1, ['Running init task...']);
        $logger->verify('log', 2);
    }


    private function getTask($logger, $validContext)
    {
        $this->make(ActionEvent::class, [
            'isError' => false
        ]);

        $dispatcher = new EventDispatcher();

        $dispatcher->addListener('wand.context.execute', function () {});

        $dispatcher->addListener('wand.file.execute', function (ActionEvent $event) {
            $event->success('ok');
        });


        $pathManager = $this->make(PathManager::class, [
            'projectDir' => realpath('.')
        ]);

        $container = new ContainerBuilder();
        $container->set('wand.path.manager', $pathManager);


        $tasks = $this->fromFile('complete');
        $options = $tasks['taskA'];

        $builder = new TaskBuilder($container);
        $task = $builder->buildTask($options);

        $task->setEventDispatcher($dispatcher);
        $task->setLogger($logger->make());

        return $task;
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