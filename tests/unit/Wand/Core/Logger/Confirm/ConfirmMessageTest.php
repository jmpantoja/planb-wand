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
 * @coversDefaultClass \PlanB\Wand\Core\Logger\Confirm\ConfirmMessage
 */
class ConfirmMessageTest extends Unit
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
     * @covers ::create
     *
     * @covers ::getMessage
     * @covers ::isTrueByDefault
     * @covers ::setDefault
     *
     */
    public function testCreate()
    {
        $confirm = ConfirmMessage::create('message');

        $this->tester->assertEquals('message (Y / n):', $confirm->getMessage());

        $this->tester->assertTrue($confirm->isTrueByDefault());

        $confirm->setDefault(false);
        $this->tester->assertFalse($confirm->isTrueByDefault());
        $this->tester->assertEquals('message (y / N):', $confirm->getMessage());


        $confirm->setDefault(true);
        $this->tester->assertTrue($confirm->isTrueByDefault());
        $this->tester->assertEquals('message (Y / n):', $confirm->getMessage());

    }


}