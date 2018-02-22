<?php
/**
 * This file is part of the planb project.
 *
 * (c) Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace PlanB\Wand\Core\File;

use PlanB\Utils\Dev\Tdd\Test\Unit;

/**
 * Class TaskManagerTest
 * @package PlanB\Spine\Core\Task
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * @coversDefaultClass \PlanB\Wand\Core\File\FileEvent
 */
class FileEventTest extends Unit
{

    /**
     * @test
     *
     * @covers ::__construct
     * @covers ::getFile
     * @covers ::getName
     * @covers ::configureLog
     */
    public function testCreate()
    {
        $file = $this->make(File::class, [
            'getTarget' => 'filename',
            'getPath' => 'target',
            'getAction' => 'create',
        ]);
        $event = new FileEvent($file);

        $event->success();
        $message = $event->getMessage();

        $lines = $message->parseVerbose();

        $this->assertContains('Create file filename', $lines[0]);

        $this->assertEquals('wand.file.create', $event->getName());
        $this->assertEquals($file, $event->getFile());

    }
}