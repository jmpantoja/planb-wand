<?php
/**
 * This file is part of the planb project.
 *
 * (c) Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace PlanB\Wand\Qa\Task;


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
 * @coversDefaultClass  \PlanB\Wand\Qa\Task\QaTask
 */
class QaTaskTest extends Unit
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
     * @covers ::hasStagedFiles
     * @covers ::shouldBeRestaged
     */
    public function testExecute()
    {

        $context = $this->getContext(true);
        $task = $this->stub(QaTask::class);
        $task->setContext($context);


        $task->allows()
            ->run(m::anyOf('lint', 'phpcpd', 'phpmd', 'phpcbf', 'restage'))
            ->andReturn(LogMessage::success())
            ->times(5);

        $task->allows()
            ->run('phpcs')
            ->never();

        $this->tester->assertTrue($task->execute()->isSuccessful());
    }


    /**
     * @test
     *
     * @covers ::execute
     * @covers ::hasStagedFiles
     */
    public function testExecuteNoStage()
    {

        $context = $this->getContext(false);
        $task = $this->stub(QaTask::class);
        $task->setContext($context);

        $task->allows()
            ->run(m::anyOf('lint', 'phpcpd', 'phpmd', 'phpcbf'))
            ->andReturn(LogMessage::success())
            ->times(4);

        $task->allows()
            ->run('restage')
            ->andReturn(LogMessage::success())
            ->never();

        $task->allows()
            ->run('phpcs')
            ->never();

        $this->tester->assertTrue($task->execute()->isSuccessful());
    }


    /**
     * @test
     *
     * @covers ::execute
     * @covers ::hasStagedFiles
     * @covers ::shouldBeRestaged
     */
    public function testExecuteFail()
    {
        $context = $this->getContext(true);
        $task = $this->stub(QaTask::class);
        $task->setContext($context);

        $task->allows()
            ->run(m::anyOf('lint', 'phpcpd', 'phpmd', 'restage', 'phpcs'))
            ->andReturn(LogMessage::success())
            ->times(4);

        $task->allows()
            ->run('phpcbf')
            ->andReturn(LogMessage::error())
            ->once();

        $task->allows()
            ->run('restage')
            ->andReturn(LogMessage::success())
            ->once();

        $this->tester->assertTrue($task->execute()->isSuccessful());
    }

    protected function getContext(bool $hasStagedFiles)
    {

        $gitManager = $this->stub(GitManager::class, [
            'hasStagedFiles' => $hasStagedFiles
        ]);

        $context = $this->stub(Context::class, [
            'getGitManager' => $gitManager
        ]);

        return $context;
    }

}