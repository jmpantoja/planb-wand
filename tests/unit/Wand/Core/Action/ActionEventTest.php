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


use Codeception\Test\Unit;
use PlanB\Utils\Dev\Tdd\Feature\Mocker;
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

    use Mocker;

    /**
     * @var \UnitTester
     */
    protected $tester;

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
        $event = $this->getEvent();

        $event->success();
        $this->tester->assertTrue($event->getMessage()->isSuccessful());
        $this->tester->assertTrue($event->isNotError());

        $event->skip();
        $this->tester->assertTrue($event->getMessage()->isSkipped());
        $this->tester->assertTrue($event->isNotError());

        $event->error();
        $this->tester->assertTrue($event->getMessage()->isError());
        $this->tester->assertFalse($event->isNotError());

        $event->error('message');
        $this->tester->assertTrue($event->getMessage()->isError());

        $this->tester->assertContains('<fg=red>ERROR:</> message', $event->getMessage()->parseVerbose());
        $this->tester->assertFalse($event->isNotError());


    }

    /**
     * @test
     * @covers ::getMessage
     *
     */
    public function testMessageException()
    {
        $event = $this->getEvent();

        $event->getMessage();

        $this->tester->assertTrue($event->getMessage()->isError());

        $lines = $event->getMessage()->parseVerbose();
        $this->tester->assertContains('No se ha asignado un estado despues de ejecutar la acción', $lines[0]);
        $this->tester->assertFalse($event->isNotError());

    }

    /**
     * @return FileEvent
     */
    protected function getEvent(): FileEvent
    {
        $file = $this->stub(File::class, [
            'getTarget' => 'target',
            'getPath' => 'target',
            'getAction' => 'action',
            'getGroup'=>'group'
        ]);
        $event = new FileEvent($file);
        return $event;
    }


}