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

use PlanB\Utils\Dev\Tdd\Test\Unit;
use PlanB\Wand\Core\Task\Task;
use PlanB\Wand\Core\Task\TaskBuilder;

/**
 * Class TaskManagerTest
 * @package PlanB\Spine\Core\Task
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * @coversDefaultClass \PlanB\Wand\Core\Task\TaskBuilder
 */
class TaskBuilderTest extends Unit
{

    /**
     * @test
     *
     * @covers ::__construct
     * @covers ::create
     *
     * @covers ::buildTask
     * @covers ::getClassName
     * @covers ::resolveActions
     *
     */
    public function create()
    {
        $builder = TaskBuilder::create();
        $options = [];

        $this->assertInstanceOf(Task::class, $builder->buildTask($options));
    }


}