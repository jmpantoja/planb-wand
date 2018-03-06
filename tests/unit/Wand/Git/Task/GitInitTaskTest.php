<?php
/**
 * This file is part of the planb project.
 *
 * (c) Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace PlanB\Wand\Git;


use Codeception\Test\Unit;
use PlanB\Utils\Dev\Tdd\Feature\Mocker;
use PlanB\Utils\Path\Path;
use PlanB\Wand\Composer\Task\ComposerTask;
use PlanB\Wand\Core\Context\Context;
use PlanB\Wand\Core\Git\GitManager;
use PlanB\Wand\Core\Logger\LogManager;
use PlanB\Wand\Core\Logger\Message\LogMessage;
use Mockery as m;
use PlanB\Wand\Git\Task\GitInitTask;

/**
 * Class ComposerTaskTest
 * @package PlanB\Wand\Composer
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * @coversDefaultClass  \PlanB\Wand\Git\Task\GitInitTask
 */
class GitInitTaskTest extends Unit
{
    use Mocker;

    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * @test
     *
     * @covers ::execute
     * @covers ::isInitialized
     */
    public function testExecute()
    {

        $task = $this->getTask(true);

        $task->allows()
            ->run('gitignore')
            ->andReturn(LogMessage::success())
            ->once();

        $task->allows()
            ->run('precommit')
            ->andReturn(LogMessage::success())
            ->once();

        $task->allows()
            ->run('commitmsg')
            ->andReturn(LogMessage::success())
            ->once();

        $task->execute();
    }


    /**
     * @test
     *
     * @covers ::execute
     * @covers ::isInitialized
     */
    public function testExecuteFirstTime()
    {

        $task = $this->getTask(false);

        $task->allows()
            ->run('git')
            ->andReturn(LogMessage::success())
            ->once();

        $task->allows()
            ->run('gitignore')
            ->andReturn(LogMessage::success())
            ->once();

        $task->allows()
            ->run('precommit')
            ->andReturn(LogMessage::success())
            ->once();

        $task->allows()
            ->run('commitmsg')
            ->andReturn(LogMessage::success())
            ->once();

        $task->execute();
    }

    /**
     * @return \Mockery\MockInterface
     */
    protected function getTask($initalized): \Mockery\MockInterface
    {
        $this->double(Path::class, [
            'isDirectory' => $initalized
        ]);

        $logger = $this->stub(LogManager::class, [
            'skip' => null
        ]);

        $gitManager = $this->stub(GitManager::class, [
            'isInitialized' => $initalized
        ]);


        $context = $this->stub(Context::class, [
            'getGitManager' => $gitManager
        ]);


        $context->allows()
            ->getPath('project')
            ->andReturn(realpath('.'));

        $task = $this->stub(GitInitTask::class);
        $task->setContext($context);

        $task->setLogger($logger);

        return $task;
    }
}