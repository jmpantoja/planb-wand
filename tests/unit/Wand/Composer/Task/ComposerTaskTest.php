<?php
/**
 * This file is part of the planb project.
 *
 * (c) Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace PlanB\Wand\Composer;


use Codeception\Test\Unit;
use PlanB\Utils\Dev\Tdd\Feature\Mocker;
use PlanB\Utils\Path\Path;
use PlanB\Wand\Composer\Task\ComposerTask;
use PlanB\Wand\Core\Context\Context;
use PlanB\Wand\Core\Logger\LogManager;
use PlanB\Wand\Core\Logger\Message\LogMessage;
use Mockery as m;

/**
 * Class ComposerTaskTest
 * @package PlanB\Wand\Composer
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * @coversDefaultClass  \PlanB\Wand\Composer\ComposerTask
 */
class ComposerTaskTest extends Unit
{
    use Mocker;

    /**
     * @var \UnitTester
     */
    protected $tester;

    public function testExecuteNoComposerLock()
    {
        $this->double(Path::class, [
            'exists' => false
        ]);

        $task = $this->getTask(LogMessage::success());

        $task->allows()
            ->run('update')
            ->andReturn(LogMessage::success())
            ->once();

        $task->execute();
    }

    public function testExecuteNoValidComposer()
    {
        $this->double(Path::class, [
            'exists' => true
        ]);

        $task = $this->getTask(LogMessage::error());

        $task->allows()
            ->run('update')
            ->andReturn(LogMessage::success())
            ->once();

        $task->execute();
    }

    public function testExecuteSkip()
    {
        $this->double(Path::class, [
            'exists' => true
        ]);

        $task = $this->getTask(LogMessage::success());

        $task->allows()
            ->run('update')
            ->never();

        $task->execute();
    }

    /**
     * @return \Mockery\MockInterface
     */
    protected function getTask($validate): \Mockery\MockInterface
    {
        $logger = $this->stub(LogManager::class, [
            'info' => null
        ]);

        $context = $this->stub(Context::class);
        $context->allows()
            ->getPath('project')
            ->andReturn(realpath('.'));

        $task = $this->stub(ComposerTask::class);
        $task->setContext($context);

        $task->allows()
            ->run('validate')
            ->andReturn($validate);

        $task->setLogger($logger);

        return $task;
    }
}