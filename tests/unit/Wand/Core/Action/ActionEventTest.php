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
 * @coversDefaultClass \PlanB\Wand\Core\Action\ActionEvent
 */
class ActionEventTest extends Unit
{
    /**
     * @test
     * @covers ::success
     * @covers ::skip
     * @covers ::error
     *
     * @covers ::isNotError
     * @covers ::getMessage
     *
     */
    public function testMessage()
    {
        $file = $this->make(File::class, [
            'getTarget' => 'target',
            'getPath' => 'target',
            'getAction' => 'action',
        ]);
        $event = new FileEvent($file);

        $event->success();
        $this->assertTrue($event->getMessage()->isSuccessful());
        $this->assertTrue($event->isNotError());

        $event->skip();
        $this->assertTrue($event->getMessage()->isSkipped());
        $this->assertTrue($event->isNotError());

        $event->error();
        $this->assertTrue($event->getMessage()->isError());
        $this->assertFalse($event->isNotError());

        $event->error('message');
        $this->assertTrue($event->getMessage()->isError());

        $this->assertContains('<fg=red>ERROR:</> message', $event->getMessage()->parseVerbose());
        $this->assertFalse($event->isNotError());
    }



    /**
     * @test
     * @covers ::getMessage
     *
     */
    public function testMessageException()
    {
        $file = $this->make(File::class, [
            'getTarget' => 'target',
            'getPath' => 'target',
            'getAction' => 'action',
        ]);
        $event = new FileEvent($file);

        $event->getMessage();

        $this->assertTrue($event->getMessage()->isError());

        $lines = $event->getMessage()->parseVerbose();
        $this->assertContains('No se ha asignado un estado despues de ejecutar la acción', $lines[0]);
        $this->assertFalse($event->isNotError());

    }




}