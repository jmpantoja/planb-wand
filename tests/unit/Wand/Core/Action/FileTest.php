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

/**
 * Class TaskManagerTest
 * @package PlanB\Spine\Core\Task
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * @coversDefaultClass \PlanB\Wand\Core\Action\File
 */
class FileTest extends Unit
{

    /**
     * @test
     *
     * @covers ::__construct
     * @covers ::create
     */
    public function create()
    {
        $file = File::create([]);

        $this->assertInstanceOf(File::class, $file);

    }
}