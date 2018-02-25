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
     * @covers ::setContainer
     * @covers ::getPathManager
     */
    public function testContainer()
    {



        $action = $this->stub(Action::class);
        $pathManager = $this->stub(PathManager::class);

        $container = new ContainerBuilder();
        $container->set('wand.path.manager', $pathManager);

        $action->setContainer($container);
        $this->tester->assertEquals($pathManager, $action->getPathManager());

    }

    /**
     * @test
     *
     * @covers ::setContainer
     * @covers ::getPathManager
     *
     * @covers \PlanB\Wand\Core\Action\Exception\InvalidServiceTypeException::create
     *
     * @expectedException \PlanB\Wand\Core\Action\Exception\InvalidServiceTypeException
     * @expectedExceptionMessage Se esperaba que el servicio 'wand.path.manager' fuera del tipo 'PlanB\Wand\Core\Path\PathManager', pero ha devuelto un 'stdClass'
     */
    public function testPathManagerException()
    {

        $action = $this->stub(Action::class);

        $pathManager = new \stdClass();

        $container = new ContainerBuilder();
        $container->set('wand.path.manager', $pathManager);

        $action->setContainer($container);
        $action->getPathManager();

    }


}