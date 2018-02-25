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
use PlanB\Wand\Core\Action\ActionEvent;
use PlanB\Wand\Core\Logger\LogManager;
use PlanB\Wand\Core\Path\PathManager;
use PlanB\Wand\Core\Task\SimpleTask;
use PlanB\Wand\Core\Task\TaskBuilder;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\Yaml\Yaml;

use Mockery as m;

/**
 * Class TaskManagerTest
 * @package PlanB\Spine\Core\Task
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * @coversDefaultClass \PlanB\Wand\Core\Task\SimpleTask
 */
class SimpleTaskTest extends Unit
{

    use Mocker;

    /**
     * @var  \UnitTester $tester
     */
    protected $tester;

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

        $logger = $this->stub(LogManager::class);

        $logger->expects()
            ->info(m::any())
            ->once();

        $logger->expects()
            ->log(m::any())
            ->twice();

        $task = $this->getTask($logger, true);

        $this->tester->assertInstanceOf(SimpleTask::class, $task);

        $task->setName('init');
        $task->launch();

    }


    private function getTask($logger, $validContext)
    {
        $this->stub(ActionEvent::class, [
            'isError' => false
        ]);

        $dispatcher = new EventDispatcher();

        $pathManager = $this->stub(PathManager::class, [
            'projectDir' => realpath('.')
        ]);

        $container = new ContainerBuilder();
        $container->set('wand.path.manager', $pathManager);


        $tasks = $this->fromFile('complete');
        $options = $tasks['taskA'];

        $builder = new TaskBuilder($container);
        $task = $builder->buildTask($options);

        $task->setEventDispatcher($dispatcher);
        $task->setLogger($logger);

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