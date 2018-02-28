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
use PlanB\Wand\Core\Action\Action;
use PlanB\Wand\Core\Context\Context;
use PlanB\Wand\Core\Path\PathManager;
use Symfony\Component\DependencyInjection\ContainerBuilder;


/**
 * Class TaskManagerTest
 * @package PlanB\Spine\Core\Task
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * @coversDefaultClass \PlanB\Wand\Core\Action\Action
 */
class ActionTest extends Unit
{

    use Mocker;

    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * @test
     *
     * @covers ::setContext
     * @covers ::setLevel
     * @covers ::getLevel
     */
    public function testContainer()
    {

        $context = $this->stub(Context::class);
        $action = $this->stub(Action::class);
        $action->setContext($context);

        $this->assertAttributeEquals($context, 'context', $action);

        $action->setLevel(5);
        $this->tester->assertEquals(5, $action->getLevel());



    }

}