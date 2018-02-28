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
use PlanB\Wand\Core\Task\Task;
use PlanB\Wand\Core\Task\TaskBuilder;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\EventDispatcher\EventDispatcher;
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

    use Mocker;

    /**
     * @var  \UnitTester $tester
     */
    protected $tester;

    /**
     * @test
     *
     * @covers ::__construct
     *
     * @covers ::setConfig
     * @covers ::getTasks
     * @covers ::buildTask
     * @covers ::resolveActions
     * @covers ::getTaskRef
     * @covers ::buildAction
     */
    public function testCreate()
    {
        $config = $this->fromFile('complete');

        $logger = $this->stub(LogManager::class);
        $dispatcher = new EventDispatcher();

        $builder = new TaskBuilder($dispatcher, $logger);
        $builder->setConfig($config);

        $tasks = $builder->getTasks();

        foreach ($tasks as $task) {
            $this->tester->assertInstanceOf(Task::class, $task);

            $this->assertContainsOnly(ActionInterface::class, $task->getActions());
            $this->tester->assertCount(3, $task->getActions());
        }

        $this->tester->assertCount(2, $tasks);
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