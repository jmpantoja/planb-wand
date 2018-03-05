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
use Mockery as m;
use PlanB\Utils\Dev\Tdd\Data\Data;
use PlanB\Utils\Dev\Tdd\Data\Provider;
use PlanB\Utils\Dev\Tdd\Feature\Mocker;
use PlanB\Wand\Core\Action\ActionEvent;
use PlanB\Wand\Core\Context\Context;
use PlanB\Wand\Core\Logger\LogManager;
use PlanB\Wand\Core\Logger\Message\LogMessage;
use PlanB\Wand\Core\Logger\Message\MessageType;
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
     * @covers \PlanB\Wand\Core\Task\Task::sequence
     * @covers \PlanB\Wand\Core\Task\Task::sequenceFrom
     *
     *
     * @covers \PlanB\Wand\Core\Task\Task::launch
     * @covers \PlanB\Wand\Core\Task\Task::configureActionLevel
     *
     * @covers \PlanB\Wand\Core\Task\Task::getEvent
     * @covers \PlanB\Wand\Core\Task\Task::setName
     * @covers \PlanB\Wand\Core\Task\Task::getName
     *
     * @covers \PlanB\Wand\Core\Task\Task::setContext
     * @covers \PlanB\Wand\Core\Task\Task::setLevel
     *
     */
    public function testLaunch()
    {

        $context = $this->stub(Context::class);

        $logger = $this->stub(LogManager::class);
        $logger->expects()
            ->begin(m::any())
            ->once();

        $logger->expects()
            ->log(m::any())
            ->times(3);

        $task = $this->getTask($logger, true);
        $this->tester->assertInstanceOf(SimpleTask::class, $task);

        $task->setName('init');
        $this->tester->assertEquals('init', $task->getName());

        $task->setContext($context);
        $this->assertAttributeEquals($context, 'context', $task);

        $task->setLevel(5);
        $this->assertAttributeEquals(5, 'level', $task);
        $this->tester->assertEquals(5, $task->getLevel());

        $task->launch();

    }

    /**
     * @test
     *
     * @dataProvider providerSequence
     *
     * @covers ::sequence
     * @covers ::sequenceFrom
     */
    public function testSequence(Data $data)
    {
        $task = $this->stub(SimpleTask::class);
        $task->allows()
            ->run(m::anyOf('A', 'C'))
            ->andReturn(LogMessage::success());

        $task->allows()
            ->run('B')
            ->andReturn($data->response);

        $this->tester->assertTrue($task->sequence('A', 'B', 'C')->getType()->is($data->expected));
    }

    public function providerSequence()
    {
        return Provider::create()
            ->add([
                'response' => LogMessage::success(),
                'expected' => MessageType::SUCCESS()
            ])
            ->add([
                'response' => LogMessage::skip(),
                'expected' => MessageType::SKIP()
            ])
            ->add([
                'response' => LogMessage::error(),
                'expected' => MessageType::ERROR()
            ])
            ->end();
    }


    private function getTask($logger, $validContext)
    {
        $this->stub(ActionEvent::class, [
            'isError' => false
        ]);

        $dispatcher = new EventDispatcher();

        $config = $this->fromFile('complete');

        $builder = new TaskBuilder($dispatcher, $logger);
        $builder->setConfig($config);

        $tasks = $builder->getTasks();
        $task = $tasks['taskA'];

        return $task;
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