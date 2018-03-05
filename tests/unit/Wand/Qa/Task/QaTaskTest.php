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
     */
    public function testExecute()
    {
        $task = $this->stub(QaTask::class);

        $task->allows()
            ->run(m::anyOf('lint', 'phpcpd', 'phpmd'))
            ->andReturn(LogMessage::success())
            ->times(3);

        $task->allows()
            ->run('phpcbf')
            ->andReturn(LogMessage::success())
            ->once();

        $task->allows()
            ->run('phpcs')
            ->never();

        $this->tester->assertTrue($task->execute()->isSuccessful());
    }

    /**
     * @test
     *
     * @covers ::execute
     */
    public function testExecuteFail()
    {
        $task = $this->stub(QaTask::class);

        $task->allows()
            ->run(m::anyOf('lint', 'phpcpd', 'phpmd'))
            ->andReturn(LogMessage::success())
            ->times(3);

        $task->allows()
            ->run('phpcbf')
            ->andReturn(LogMessage::error())
            ->once();

        $task->allows()
            ->run('phpcs')
            ->andReturn(LogMessage::success())
            ->once();

        $this->tester->assertTrue($task->execute()->isSuccessful());
    }

}