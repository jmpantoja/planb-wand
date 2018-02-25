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

use Codeception\Test\Unit;
use PlanB\Utils\Dev\Tdd\Feature\Mocker;


/**
 * Class LogManagerTest
 * @package PlanB\Spine\Core\Task
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * @coversDefaultClass \PlanB\Wand\Core\Logger\Message\MessageEvent
 */
class MessageEventTest extends Unit
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
     * @covers ::getMessage
     */
    public function testConstruct()
    {
        $message = $this->double(LogMessage::class)->make();
        $event = new MessageEvent($message);

        $this->tester->assertEquals($message, $event->getMessage());
    }

}