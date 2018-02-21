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
 * @coversDefaultClass \PlanB\Wand\Core\Logger\Message\MessageType
 */
class MessageTypeTest extends Unit
{

    /**
     * @test
     *
     * @covers ::isInfo
     * @covers ::isSuccessful
     * @covers ::isSkipped
     * @covers ::isError
     */
    public function testInfo()
    {
        $type = MessageType::INFO();

        $this->assertTrue($type->isInfo());
        $this->assertFalse($type->isSuccessful());
        $this->assertFalse($type->isSkipped());
        $this->assertFalse($type->isError());
    }

    /**
     * @test
     *
     * @covers ::isInfo
     * @covers ::isSuccessful
     * @covers ::isSkipped
     * @covers ::isError
     */
    public function testSuccess()
    {
        $type = MessageType::SUCCESS();

        $this->assertFalse($type->isInfo());
        $this->assertTrue($type->isSuccessful());
        $this->assertFalse($type->isSkipped());
        $this->assertFalse($type->isError());
    }

    /**
     * @test
     *
     * @covers ::isInfo
     * @covers ::isSuccessful
     * @covers ::isSkipped
     * @covers ::isError
     */
    public function testSkip()
    {
        $type = MessageType::SKIP();

        $this->assertFalse($type->isInfo());
        $this->assertFalse($type->isSuccessful());
        $this->assertTrue($type->isSkipped());
        $this->assertFalse($type->isError());
    }


    /**
     * @test
     *
     * @covers ::isInfo
     * @covers ::isSuccessful
     * @covers ::isSkipped
     * @covers ::isError
     */
    public function testError()
    {
        $type = MessageType::ERROR();

        $this->assertFalse($type->isInfo());
        $this->assertFalse($type->isSuccessful());
        $this->assertFalse($type->isSkipped());
        $this->assertTrue($type->isError());
    }

}