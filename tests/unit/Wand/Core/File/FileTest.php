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
 * @coversDefaultClass \PlanB\Wand\Core\File\File
 */
class FileTest extends Unit
{

    /**
     * @test
     *
     * @covers ::__construct
     * @covers ::create
     * @covers ::getEventName
     */
    public function create()
    {
        $file = File::create([]);

        $this->assertInstanceOf(File::class, $file);

        $this->assertEquals('wand.file.execute', $file->getEventName());

    }
}