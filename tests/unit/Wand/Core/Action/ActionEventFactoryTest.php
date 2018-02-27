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
use PlanB\Utils\Dev\Tdd\Data\Data;
use PlanB\Utils\Dev\Tdd\Data\Provider;
use PlanB\Utils\Dev\Tdd\Feature\Mocker;
use PlanB\Wand\Core\Action\Exception\ActionEventFactoryException;
use PlanB\Wand\Core\Command\Command;
use PlanB\Wand\Core\Command\CommandEvent;
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
     * @dataProvider providerFromAction
     *
     * @covers ::fromAction
     *
     * @covers \PlanB\Wand\Core\Action\Exception\ActionEventFactoryException::create
     */
    public function testFromAction(Data $data)
    {

        $event = ActionEventFactory::fromAction($data->action);
        $this->tester->assertInstanceOf($data->expected, $event);

        $this->tester->expectException(ActionEventFactoryException::class, function () {
            $badFile = $this->stub(ActionInterface::class);
            ActionEventFactory::fromAction($badFile);
        });
    }

    public function providerFromAction()
    {
        return Provider::create()
            ->add([
                'action' => $this->stub(File::class),
                'expected'=>FileEvent::class
            ])
            ->add([
                'action' => $this->stub(Command::class),
                'expected'=>CommandEvent::class
            ])

            ->end();
    }
}