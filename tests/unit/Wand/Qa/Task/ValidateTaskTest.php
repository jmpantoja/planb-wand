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
use Mockery as m;
use PlanB\Utils\Dev\Tdd\Feature\Mocker;
use PlanB\Wand\Core\Context\Context;
use PlanB\Wand\Core\Git\GitManager;
use PlanB\Wand\Core\Logger\Message\LogMessage;

/**
 * Class ComposerTaskTest
 * @package PlanB\Wand\Composer
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * @coversDefaultClass  \PlanB\Wand\Qa\Task\ValidateTask
 */
class ValidateTaskTest extends Unit
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

        $context = $this->stub(Context::class);
        $task = $this->stub(ValidateTask::class);
        $task->setContext($context);


        $task->allows()
            ->run(m::anyOf('@composer/validate', '@qa', '@sami', '@tdd/unit'))
            ->andReturn(LogMessage::success())
            ->times(4);

        $this->tester->assertTrue($task->execute()->isSuccessful());
    }


    /**
     * @test
     *
     * @covers ::execute
     */
    public function testExecuteFail()
    {

        $context = $this->stub(Context::class);
        $task = $this->stub(ValidateTask::class);
        $task->setContext($context);


        $task->allows()
            ->run(m::anyOf('@composer/validate', '@qa'))
            ->andReturn(LogMessage::error())
            ->times(2);

        $task->allows()
            ->run(m::anyOf('@sami', '@tdd/unit'))
            ->never();

        $this->tester->assertTrue($task->execute()->isError());
    }

}