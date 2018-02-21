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

use PlanB\Utils\Dev\Tdd\Test\Unit;
use PlanB\Wand\Core\Logger\Message\LogMessage;
use PlanB\Wand\Core\Logger\Question\QuestionEvent;
use PlanB\Wand\Core\Logger\Question\QuestionMessage;


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
        $confirm = $this->make(ConfirmMessage::class);
        $event = new ConfirmEvent($confirm);

        $this->assertEquals($confirm, $event->getConfirm());

        $event->setAnswer(true);
        $this->assertTrue($event->getAnswer());

        $event->setAnswer(false);
        $this->assertFalse($event->getAnswer());
    }


}