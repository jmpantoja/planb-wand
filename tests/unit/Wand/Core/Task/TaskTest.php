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
        $tasks = $this->fromFile('complete');

        $builder = $this->getBuilder();

        foreach ($tasks as $options) {


            $task = $builder->buildTask($options);
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
     *
     */
    public function testGet()
    {
        $tasks = $this->fromFile('complete');
        $options = $tasks['taskA'];

        $builder = $this->getBuilder();

        $task = $builder->buildTask($options);

        $this->tester->assertInstanceOf(Task::class, $task);

        $this->tester->assertTrue($task->exists('actionA'));
        $this->tester->assertTrue($task->exists('actionB'));
        $this->tester->assertFalse($task->exists('actionXXXX'));

        $this->tester->assertInstanceOf(ActionInterface::class, $task->get('actionA'));
        $this->tester->assertInstanceOf(ActionInterface::class, $task->get('actionB'));

        $this->tester->assertCount(2, $task->getActions());

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

        $builder = $this->getBuilder();

        $task = $builder->buildTask($options);
        $this->tester->assertInstanceOf(Task::class, $task);

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

    /**
     * @return TaskBuilder
     */
    protected function getBuilder(): TaskBuilder
    {
        $context = $this->stub(ContextManager::class, [
            'getContext' => $this->stub(Context::class)
        ]);

        $builder = new TaskBuilder($context);
        return $builder;
    }


}