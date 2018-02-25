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
 * @coversDefaultClass \PlanB\Wand\Core\Logger\Message\MessageType
 */
class MessageTypeTest extends Unit
{

    use Mocker;

    /**
     * @var  \UnitTester $tester
     */
    protected $tester;

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

        $this->tester->assertTrue($type->isInfo());
        $this->tester->assertFalse($type->isSuccessful());
        $this->tester->assertFalse($type->isSkipped());
        $this->tester->assertFalse($type->isError());
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

        $this->tester->assertFalse($type->isInfo());
        $this->tester->assertTrue($type->isSuccessful());
        $this->tester->assertFalse($type->isSkipped());
        $this->tester->assertFalse($type->isError());
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

        $this->tester->assertFalse($type->isInfo());
        $this->tester->assertFalse($type->isSuccessful());
        $this->tester->assertTrue($type->isSkipped());
        $this->tester->assertFalse($type->isError());
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

        $this->tester->assertFalse($type->isInfo());
        $this->tester->assertFalse($type->isSuccessful());
        $this->tester->assertFalse($type->isSkipped());
        $this->tester->assertTrue($type->isError());
    }

}