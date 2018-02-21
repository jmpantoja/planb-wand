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


/**
 * Class LogManagerTest
 * @package PlanB\Spine\Core\Task
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * @coversDefaultClass \PlanB\Wand\Core\Logger\Message\MessageEvent
 */
class MessageEventTest extends Unit
{

    /**
     * @test
     *
     * @covers ::__construct
     * @covers ::getMessage
     */
    public function testConstruct()
    {
        $message = $this->make(LogMessage::class);
        $event = new MessageEvent($message);

        $this->assertEquals($message, $event->getMessage());
    }

}