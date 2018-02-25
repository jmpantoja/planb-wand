<?php
/**
 * This file is part of the planb project.
 *
 * (c) Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace PlanB\Spine\Core\Task;

use Codeception\Test\Unit;
use PlanB\Utils\Dev\Tdd\Feature\Mocker;
use PlanB\Wand\Core\Action\ActionInterface;
use PlanB\Wand\Core\Task\TaskOptions;

/**
 * Class TaskManagerTest
 * @package PlanB\Spine\Core\Task
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * @coversDefaultClass \PlanB\Wand\Core\Task\TaskOptions
 */
class TaskOptionsTest extends Unit
{

    use Mocker;

    /**
     * @var  \UnitTester $tester
     */
    protected $tester;

    /**
     * @test
     *
     * @covers ::configure
     * @covers ::defineActions
     * @covers ::defineDescription
     * @covers ::isValidActions
     */
    public function resolve()
    {
        $params = [
            'description' => 'la descripción de la tareas',
            'actions' => [
                $this->stub(ActionInterface::class),
                $this->stub(ActionInterface::class)
            ]
        ];

        $options = TaskOptions::create()
            ->resolve($params);

        $this->tester->assertEquals($params, $options);
    }


    /**
     * @test
     *
     * @covers ::configure
     * @covers ::defineActions
     * @covers ::defineDescription
     *
     * @expectedException \Symfony\Component\OptionsResolver\Exception\InvalidOptionsException
     */
    public function resolveInvalidDescription()
    {
        $params = [
            'description' => ['no se admiten strings ', 'y eso es un array'],
            'actions' => [
                $this->stub(ActionInterface::class),
                $this->stub(ActionInterface::class)
            ]
        ];

        $options = TaskOptions::create()
            ->resolve($params);

        $this->tester->assertEquals($params, $options);
    }

    /**
     * @test
     *
     * @covers ::configure
     * @covers ::defineActions
     * @covers ::defineDescription
     * @covers ::isValidActions
     *
     * @expectedException \Symfony\Component\OptionsResolver\Exception\InvalidOptionsException
     */
    public function resolveInvalidActions()
    {
        $params = [
            'description' =>'la descripción de la tareas',
            'actions' => [
                'solo se admiten instancias de action',
                $this->stub(ActionInterface::class)
            ]
        ];

        $options = TaskOptions::create()
            ->resolve($params);

        $this->tester->assertEquals($params, $options);
    }
}