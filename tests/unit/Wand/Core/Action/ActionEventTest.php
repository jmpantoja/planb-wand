<?php
/**
 * This file is part of the planb project.
 *
 * (c) Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace PlanB\Wand\Core\Action;

use PlanB\Utils\Dev\Tdd\Test\Unit;
use PlanB\Wand\Core\File\File;


/**
 * Class LogMessageTest
 *
 * @package PlanB\Spine\Core\Task
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * @coversDefaultClass \PlanB\Wand\Core\Action\ActionEvent
 */
class ActionEventTest extends Unit
{

    /**
     * @test
     *
     * @covers ::__construct
     *
     * @covers ::success
     * @covers ::skip
     * @covers ::error
     * @covers ::isNotError
     *
     * @covers ::getAction
     * @covers ::getMessage
     *
     */
    public function testCreate()
    {
        $action = $this->make(ActionInterface::class);

        $event = new ActionEvent($action);
        $this->assertEquals($action, $event->getAction());


        $event->success('message');
        $this->assertTrue($event->getMessage()->isSuccessful());
        $this->assertTrue($event->isNotError());

        $event->skip('message');
        $this->assertTrue($event->getMessage()->isSkipped());
        $this->assertTrue($event->isNotError());


        $event->error('message');
        $this->assertTrue($event->getMessage()->isError());
        $this->assertFalse($event->isNotError());

    }

    /**
     * @test
     *
     * @covers ::__construct
     * @covers ::getFile
     *
     */
    public function testFile()
    {
        $action = $this->make(File::class);

        $event = new ActionEvent($action);
        $this->assertEquals($action, $event->getFile());
    }

    /**
     * @test
     *
     * @covers ::__construct
     * @covers ::getFile
     *
     * @covers \PlanB\Wand\Core\Action\Exception\InvalidActionException::expectedFile
     *
     * @expectedException \PlanB\Wand\Core\Action\Exception\InvalidActionException
     * @expectedExceptionMessageRegExp   /la acción es de tipo \w+, y se esperaba un File/
     */
    public function testFileException()
    {
        $action = $this->make(ActionInterface::class);

        $event = new ActionEvent($action);
        $this->assertEquals($action, $event->getFile());
    }

}