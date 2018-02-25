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
use PlanB\Wand\Core\Action\Exception\ActionEventFactoryException;
use PlanB\Wand\Core\Command\Command;
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

    use Mocker;

    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * @test
     * @covers ::fromAction
     *
     * @covers \PlanB\Wand\Core\Action\Exception\ActionEventFactoryException::create
     */
    public function testFromFile()
    {
        $file = $this->stub(File::class);
        $event = ActionEventFactory::fromAction($file);

        $this->tester->assertInstanceOf(FileEvent::class, $event);
        $this->tester->assertEquals($file, $event->getFile());

        $this->tester->expectException(ActionEventFactoryException::class, function () {
            $badFile = $this->stub(Command::class);
            ActionEventFactory::fromAction($badFile);
        });


    }
}