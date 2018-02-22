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
use PlanB\Wand\Core\Action\Action;
use PlanB\Wand\Core\Path\PathManager;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;


/**
 * Class TaskManagerTest
 * @package PlanB\Spine\Core\Task
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * @coversDefaultClass \PlanB\Wand\Core\Action\Action
 */
class ActionTest extends Unit
{

    /**
     * @test
     *
     * @covers ::setContainer
     * @covers ::getPathManager
     */
    public function testContainer()
    {

        $action = $this->make(Action::class);

        $pathManager = $this->make(PathManager::class);

        $container = new ContainerBuilder();
        $container->set('wand.path.manager', $pathManager);

        $action->setContainer($container);
        $this->assertEquals($pathManager, $action->getPathManager());

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

        $action = $this->make(Action::class);

        $pathManager = new \stdClass();

        $container = new ContainerBuilder();
        $container->set('wand.path.manager', $pathManager);

        $action->setContainer($container);
        $action->getPathManager();

    }


}