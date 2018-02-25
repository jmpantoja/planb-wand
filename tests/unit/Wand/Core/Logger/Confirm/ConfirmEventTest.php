<?php
/**
 * This file is part of the planb project.
 *
 * (c) Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace PlanB\Wand\Core\Logger\Confirm;

use Codeception\Test\Unit;
use PlanB\Utils\Dev\Tdd\Feature\Mocker;


/**
 * Class LogMessageTest
 *
 * @package PlanB\Spine\Core\Task
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * @coversDefaultClass \PlanB\Wand\Core\Logger\Confirm\ConfirmEvent
 */
class ConfirmEventTest extends Unit
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
     * @covers ::getConfirm
     *
     * @covers ::setAnswer
     * @covers ::getAnswer
     *
     */
    public function testCreate()
    {
        $confirm = $this->stub(ConfirmMessage::class);
        $event = new ConfirmEvent($confirm);

        $this->tester->assertEquals($confirm, $event->getConfirm());

        $event->setAnswer(true);
        $this->tester->assertTrue($event->getAnswer());

        $event->setAnswer(false);
        $this->tester->assertFalse($event->getAnswer());
    }


}