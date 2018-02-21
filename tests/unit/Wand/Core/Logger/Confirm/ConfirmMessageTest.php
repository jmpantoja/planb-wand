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
use PlanB\Wand\Core\Logger\Confirm\ConfirmMessage;
use PlanB\Wand\Core\Logger\Message\LogMessage;
use PlanB\Wand\Core\Logger\Question\QuestionMessage;


/**
 * Class LogMessageTest
 *
 * @package PlanB\Spine\Core\Task
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * @coversDefaultClass \PlanB\Wand\Core\Logger\Confirm\ConfirmMessage
 */
class ConfirmMessageTest extends Unit
{

    /**
     * @test
     *
     * @covers ::__construct
     * @covers ::create
     *
     * @covers ::getMessage
     * @covers ::getDefault
     * @covers ::setDefault
     *
     */
    public function testCreate()
    {
        $confirm = ConfirmMessage::create('message');

        $this->assertEquals('message (Y / n):', $confirm->getMessage());

        $this->assertTrue($confirm->getDefault());

        $confirm->setDefault(false);
        $this->assertFalse($confirm->getDefault());
        $this->assertEquals('message (y / N):', $confirm->getMessage());


        $confirm->setDefault(true);
        $this->assertTrue($confirm->getDefault());
        $this->assertEquals('message (Y / n):', $confirm->getMessage());

    }


}