<?php
/**
 * This file is part of the planb project.
 *
 * (c) Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace PlanB\Wand\Core\Logger\Message;

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
 * @coversDefaultClass \PlanB\Wand\Core\Logger\Question\QuestionEvent
 */
class QuestionEventTest extends Unit
{

    /**
     * @test
     *
     * @covers ::__construct
     * @covers ::getQuestion
     *
     * @covers ::setAnswer
     * @covers ::getAnswer
     *
     */
    public function testCreate()
    {
        $question = $this->make(QuestionMessage::class);
        $event = new QuestionEvent($question);

        $this->assertEquals($question, $event->getQuestion());

        $event->setAnswer('answer');

        $this->assertEquals('answer', $event->getAnswer());
    }


}