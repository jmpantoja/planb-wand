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
use PlanB\Wand\Core\File\FileEvent;

/**
 * Class CustomConfigTest
 * @package PlanB\Wand\Core\Config
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * @coversDefaultClass \PlanB\Wand\Core\Action\ActionEventFactory
 */
class ActionEventFactoryTest extends Unit
{
    /**
     * @test
     * @covers ::fromAction
     *
     */
    public function testFromFile()
    {
        $file = $this->make(File::class);
        $event = ActionEventFactory::fromAction($file);

        $this->assertInstanceOf(FileEvent::class, $event);
        $this->assertEquals($file, $event->getFile());
    }


    /**
     * @test
     * @covers ::fromAction
     *
     * @covers \PlanB\Wand\Core\Action\Exception\ActionEventFactoryException::create()
     *
     * @expectedException \PlanB\Wand\Core\Action\Exception\ActionEventFactoryException
     * @expectedExceptionMessageRegExp /No es posible crear un evento para la clase '\w+'/
     */
    public function testFromActionException()
    {
        $file = $this->make(ActionInterface::class);
        ActionEventFactory::fromAction($file);
    }

}