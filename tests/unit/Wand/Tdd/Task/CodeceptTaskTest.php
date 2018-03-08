<?php
/**
 * This file is part of the planb project.
 *
 * (c) Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace PlanB\Wand\Tdd\Task;


use Codeception\Test\Unit;
use PlanB\Utils\Dev\Tdd\Feature\Mocker;
use PlanB\Wand\Core\File\File;
use Mockery as m;
use PlanB\Wand\Core\Logger\LogManager;
use PlanB\Wand\Core\Logger\Message\LogMessage;

/**
 * Class CodeceptTaskTest
 * @package PlanB\Wand\Tdd\Task
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * @coversDefaultClass \PlanB\Wand\Tdd\Task\CodeceptTask
 */
class CodeceptTaskTest extends Unit
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
        /** @var File $file */
        $file = $this->stub(File::class, [
            'exists' => false
        ]);

        /** @var LogManager $logger */
        $logger = $this->stub(LogManager::class);
        $logger->allows()
            ->skip(m::any())
            ->never();

        /** @var CodeceptTask $task */
        $task = $this->stub(CodeceptTask::class);
        $task->setLogger($logger);

        $task->allows()
            ->file('codeception')
            ->andReturn($file);

        $task->allows()
            ->run('phpunit')
            ->once()
            ->andReturn(LogMessage::info());

        $task->allows()
            ->run('codecept_bootstrap')
            ->once()
            ->andReturns(LogMessage::info());

        $task->allows()
            ->run('codeception')
            ->once()
            ->andReturns(LogMessage::info());


        $task->allows()
            ->run('unit_bootstrap')
            ->once()
            ->andReturns(LogMessage::info());

        $task->allows()
            ->run('acceptance_bootstrap')
            ->once()
            ->andReturns(LogMessage::info());


        $task->allows()
            ->run('functional_bootstrap')
            ->once()
            ->andReturns(LogMessage::info());


        $task->execute();
    }


    /**
     * @test
     *
     * @covers ::execute
     */
    public function testExecuteSkip()
    {
        /** @var File $file */
        $file = $this->stub(File::class, [
            'exists' => true
        ]);

        /** @var LogManager $logger */
        $logger = $this->stub(LogManager::class);
        $logger->allows()
            ->skip(m::any())
            ->once();

        /** @var CodeceptTask $task */
        $task = $this->stub(CodeceptTask::class);
        $task->setLogger($logger);

        $task->allows()
            ->file('codeception')
            ->andReturn($file);

        $task->allows()
            ->run('phpunit')
            ->once()
            ->andReturn(LogMessage::info());

        $task->allows()
            ->run('codecept_bootstrap')
            ->never()
            ->andReturns(LogMessage::info());

        $task->allows()
            ->run('codeception')
            ->never()
            ->andReturns(LogMessage::info());


        $task->allows()
            ->run('unit_bootstrap')
            ->once()
            ->andReturns(LogMessage::info());

        $task->allows()
            ->run('acceptance_bootstrap')
            ->once()
            ->andReturns(LogMessage::info());


        $task->allows()
            ->run('functional_bootstrap')
            ->once()
            ->andReturns(LogMessage::info());


        $task->execute();
    }

}