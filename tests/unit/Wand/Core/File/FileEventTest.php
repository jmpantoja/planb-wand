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

use Codeception\Test\Unit;
use PlanB\Utils\Dev\Tdd\Feature\Mocker;

/**
 * Class TaskManagerTest
 * @package PlanB\Spine\Core\Task
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * @coversDefaultClass \PlanB\Wand\Core\File\FileEvent
 */
class FileEventTest extends Unit
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
     * @covers ::getFile
     * @covers ::getName
     * @covers ::configureLog
     */
    public function testCreate()
    {
        $file = $this->stub(File::class, [
            'getTarget' => 'filename',
            'getPath' => 'target',
            'getAction' => 'create',
            'getGroup' => 'group',
        ]);
        $event = new FileEvent($file);

        $event->success();
        $message = $event->getMessage();

        $lines = $message->parseVerbose();

        $this->tester->assertContains('[group] Create file filename', $lines[0]);

        $this->tester->assertEquals('wand.file.create', $event->getName());
        $this->tester->assertEquals($file, $event->getFile());

    }
}